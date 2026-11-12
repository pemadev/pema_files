<?php

namespace App\Http\Controllers\Ppid;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Controller dasar untuk daftar, detail, ubah status, dan ekspor CSV
 * data layanan PPID (database production). Turunannya cukup mengisi properti di bawah.
 */
abstract class PpidRecordController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;
    protected string $view;       // folder view: ppid/{view}
    protected string $routeName;  // nama route: ppid.{routeName}.*
    protected string $title;
    protected array $with = ['user', 'latestStatus'];

    /** Panjang kolom info di tabel status (varchar 255). */
    protected const NOTE_MAX = 255;

    abstract protected function exportHeader(): array;

    abstract protected function exportRow(Model $item): array;

    protected function filters(Request $request): array
    {
        return $request->only(['q', 'status', 'tahun', 'bulan']);
    }

    public function index(Request $request)
    {
        $model = $this->model;
        $filters = $this->filters($request);

        $items = $model::query()
            ->with($this->with)
            ->filter($filters)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view("ppid.{$this->view}.index", [
            'title'        => $this->title,
            'items'        => $items,
            'filters'      => $filters,
            'statuses'     => $model::STATUSES,
            'statusCounts' => collect($model::statusCounts($filters)),
            'years'        => $this->availableYears(),
            'routeName'    => $this->routeName,
        ]);
    }

    public function show(int $id)
    {
        $item = $this->model::with(array_merge($this->with, ['statuses']))->findOrFail($id);

        return view("ppid.{$this->view}.show", [
            'title'     => $this->title . ' ' . $item->nomor,
            'item'      => $item,
            'statuses'  => $this->model::STATUSES,
            'routeName' => $this->routeName,
            'noteField' => 'info',
            'noteMax'   => self::NOTE_MAX,
        ]);
    }

    /**
     * Ubah status = menambah satu baris riwayat status di server,
     * sama seperti yang dilakukan portal PPID (status_by = nama admin).
     */
    public function update(Request $request, int $id)
    {
        $model = $this->model;
        $item = $model::findOrFail($id);

        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', array_keys($model::STATUSES))],
            'info'   => ['nullable', 'string', 'max:' . self::NOTE_MAX],
        ]);

        $label = $model::STATUSES[$data['status']]['label'];

        $item->statuses()->create([
            'status'    => $data['status'],
            'status_by' => $request->user()?->name ?? 'Admin',
            'active'    => true,
            'info'      => filled($data['info'] ?? null) ? $data['info'] : 'Status diubah menjadi ' . $label,
        ]);

        return redirect()
            ->route("ppid.{$this->routeName}.show", $item->id)
            ->with('success', 'Status ' . $item->nomor . ' diperbarui menjadi "' . $label . '".');
    }

    public function export(Request $request): StreamedResponse
    {
        $model = $this->model;
        $filters = $this->filters($request);
        $filename = 'ppid-' . $this->routeName . '-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($model, $filters) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM agar Excel membaca UTF-8
            fputcsv($out, $this->exportHeader(), ';', '"', '');

            $model::query()->with($this->with)->filter($filters)->orderByDesc('id')->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $row) {
                    fputcsv($out, $this->exportRow($row), ';', '"', '');
                }
            });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    protected function availableYears(): array
    {
        $first = $this->model::query()->min('created_at');
        $current = (int) now()->format('Y');
        $from = $first ? (int) substr((string) $first, 0, 4) : $current;

        return range($current, min($from, $current));
    }
}
