<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(Request $request): View
    {
        $partners = Partner::query()
            ->when($request->search, fn($q, $v) => $q->where('name', 'like', "%{$v}%"))
            ->orderBy('sort_order')
            ->paginate(15)
            ->appends(request()->query());

        return view('admin.mitra.index', compact('partners'));
    }

    public function create(): View
    {
        $partners = Partner::orderBy('sort_order')->get();
        return view('admin.mitra.form', [
            'partner' => new Partner(),
            'partners' => $partners,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'website'    => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'logo'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
        ], [
            'name.required'       => 'Nama wajib diisi.',
            'name.string'         => 'Nama harus berupa teks.',
            'name.max'            => 'Nama maksimal :max karakter.',
            'website.url'         => 'Format URL website tidak valid.',
            'website.max'         => 'URL website maksimal :max karakter.',
            'sort_order.integer'  => 'Urutan harus berupa angka.',
            'sort_order.min'      => 'Urutan minimal 0.',
            'logo.image'          => 'File harus berupa gambar.',
            'logo.mimes'          => 'Format logo harus jpeg, png, jpg, webp, atau svg.',
            'logo.max'            => 'Ukuran logo maksimal :max KB.',
        ]);

        // Ensure unique sort_order globally
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Partner::where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($validated);

        return redirect()->route('admin.mitra.index')
            ->with('success', 'Mitra kerja berhasil ditambahkan.');
    }

    public function edit(Partner $partner): View
    {
        $partners = Partner::where('id', '!=', $partner->id)->orderBy('sort_order')->get();
        return view('admin.mitra.form', compact('partner', 'partners'));
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'website'    => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'logo'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
        ], [
            'name.required'       => 'Nama wajib diisi.',
            'name.string'         => 'Nama harus berupa teks.',
            'name.max'            => 'Nama maksimal :max karakter.',
            'website.url'         => 'Format URL website tidak valid.',
            'website.max'         => 'URL website maksimal :max karakter.',
            'sort_order.integer'  => 'Urutan harus berupa angka.',
            'sort_order.min'      => 'Urutan minimal 0.',
            'logo.image'          => 'File harus berupa gambar.',
            'logo.mimes'          => 'Format logo harus jpeg, png, jpg, webp, atau svg.',
            'logo.max'            => 'Ukuran logo maksimal :max KB.',
        ]);

        // Ensure unique sort_order globally (exclude current item)
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Partner::where('id', '!=', $partner->id)->where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($validated);

        return redirect()->route('admin.mitra.index')
            ->with('success', 'Mitra kerja berhasil diperbarui.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.mitra.index')
            ->with('success', 'Mitra kerja berhasil dihapus.');
    }
}
