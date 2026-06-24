<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = Report::query()
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->filter, fn($q, $v) => $q->where('year', $v))
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(request()->query());

        $years = Report::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('admin.laporan.index', compact('reports', 'years'));
    }

    public function create()
    {
        return view('admin.laporan.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'file'         => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
            'year'         => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'description'  => ['nullable', 'string', 'max:1000'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'title.required'        => 'Judul wajib diisi.',
            'title.string'          => 'Judul harus berupa teks.',
            'title.max'             => 'Judul maksimal :max karakter.',
            'file.required'         => 'File wajib diisi.',
            'file.file'             => 'Harus berupa file.',
            'file.mimes'            => 'Format file harus pdf, doc, docx, xls, atau xlsx.',
            'file.max'              => 'Ukuran file maksimal :max KB.',
            'year.required'         => 'Tahun wajib diisi.',
            'year.integer'          => 'Tahun harus berupa angka.',
            'year.min'              => 'Tahun minimal 2000.',
            'year.max'              => 'Tahun maksimal :max.',
            'description.string'    => 'Deskripsi harus berupa teks.',
            'description.max'       => 'Deskripsi maksimal :max karakter.',
            'is_published.boolean'  => 'Status publikasi tidak valid.',
        ]);

        $validated['file'] = $request->file('file')->store('reports', 'public');
        $validated['is_published'] = $request->boolean('is_published');

        Report::create($validated);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit(Report $report)
    {
        return view('admin.laporan.form', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'file'         => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
            'year'         => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'description'  => ['nullable', 'string', 'max:1000'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'title.required'        => 'Judul wajib diisi.',
            'title.string'          => 'Judul harus berupa teks.',
            'title.max'             => 'Judul maksimal :max karakter.',
            'file.file'             => 'Harus berupa file.',
            'file.mimes'            => 'Format file harus pdf, doc, docx, xls, atau xlsx.',
            'file.max'              => 'Ukuran file maksimal :max KB.',
            'year.required'         => 'Tahun wajib diisi.',
            'year.integer'          => 'Tahun harus berupa angka.',
            'year.min'              => 'Tahun minimal 2000.',
            'year.max'              => 'Tahun maksimal :max.',
            'description.string'    => 'Deskripsi harus berupa teks.',
            'description.max'       => 'Deskripsi maksimal :max karakter.',
            'is_published.boolean'  => 'Status publikasi tidak valid.',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('reports', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $report->update($validated);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function downloadFile(Report $report)
    {
        if (!$report->file) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = $report->file;
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($path, $report->title . '.' . pathinfo($path, PATHINFO_EXTENSION));
    }
}
