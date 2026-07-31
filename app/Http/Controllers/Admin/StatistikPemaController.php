<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatistikPema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatistikPemaController extends Controller
{
    public function index(): View
    {
        $statistik = StatistikPema::orderBy('urutan')->get();

        return view('admin.statistik.index', compact('statistik'));
    }

    public function create(): View
    {
        $item = new StatistikPema();

        return view('admin.statistik.form', compact('item'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        StatistikPema::create($data);

        return redirect()
            ->route('admin.statistik.index')
            ->with('status', 'Statistik berhasil ditambahkan.');
    }

    public function edit(StatistikPema $statistik): View
    {
        return view('admin.statistik.form', ['item' => $statistik]);
    }

    public function update(Request $request, StatistikPema $statistik): RedirectResponse
    {
        $data = $this->validated($request);

        $statistik->update($data);

        return redirect()
            ->route('admin.statistik.index')
            ->with('status', 'Statistik berhasil diperbarui.');
    }

    public function destroy(StatistikPema $statistik): RedirectResponse
    {
        $statistik->delete();

        return redirect()
            ->route('admin.statistik.index')
            ->with('status', 'Statistik berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'label'     => ['required', 'string', 'max:150'],
            'value'     => ['required', 'numeric'],
            'decimals'  => ['nullable', 'integer', 'min:0', 'max:3'],
            'prefix'    => ['nullable', 'string', 'max:20'],
            'suffix'    => ['nullable', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'urutan'    => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['decimals']  = $data['decimals'] ?? 0;
        $data['urutan']    = $data['urutan'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}