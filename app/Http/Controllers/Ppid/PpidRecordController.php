<?php

namespace App\Http\Controllers\Ppid;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Controller dasar untuk daftar, detail, ubah status, dan ekspor CSV
 * data layanan PPID. Turunannya cukup mengisi properti di bawah.
 */
abstract class PpidRecordController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;
    protected string $view;       // folder view: ppid/{view}
    protected string $routeName;  // nama route: ppid.{routeName}.*
    protected string $title;
    protected string $noteField;  // kolom catatan/tanggapan petugas
    protected array $with = [];   // relasi yang dimuat di daftar & ekspor

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

        // Jumlah per status (mengikuti filter lain, tanpa filter status)
        $statusCounts = $model::query()
            ->filter(array_diff_key($filters, ['status' => true]))
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view("ppid.{$this->view}.index", [
            'title'        => $this->title,
            'items'        => $items,
            'filters'      => $filters,
            'statuses'     => $model::STATUSES,
            'statusCounts' => $statusCounts,
            'years'        => $this->availableYears(),
            'routeName'    => $this->routeName,
        ]);
    }

    public function show(int $id)
    {
        $item = $this->model::findOrFail($id);

        return view("ppid.{$this->view}.show", [
            'title'     => $this->title . ' ' . $item->nomor,
            'item'      => $item,
            'statuses'  => $this->model::STATUSES,
            'routeName' => $this->routeName,
            'noteField' => $this->noteField,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $model = $this->model;
        $item = $model::findOrFail($id);

        $data = $request->validate([
            'status'          => ['required', 'in:' . implode(',', array_keys($model::STATUSES))],
            $this->noteField  => ['nullable', 'string', 'max:5000'],
        ]);

        $isFinal = in_array($data['status'], $model::finalStatuses(), true);
        $data['tanggal_selesai'] = $isFinal ? ($item->tanggal_selesai ?? now()->toDateString()) : null;

        $item->update($data);

        return redirect()
            ->route("ppid.{$this->routeName}.show", $item->id)
            ->with('success', 'Status ' . $item->nomor . ' diperbarui menjadi "' . $item->status_label . '".');
    }

    public function export(Request $request): StreamedResponse
    {
        $model = $this->model;
        $filters = $this->filters($request);
        $filename = 'ppid-' . $this->routeName . '-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($model, $filters) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM agar Excel membaca UTF-8
            fputcsv($out, $this->exportHeader(), ';');

            $model::query()->with($this->with)->filter($filters)->latest()->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $row) {
                    fputcsv($out, $this->exportRow($row), ';');
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
