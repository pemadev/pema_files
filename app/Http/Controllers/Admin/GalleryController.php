<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $galleries = Gallery::query()
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(request()->query());

        return view('admin.galeri.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galeri.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'images'     => ['required', 'array'],
            'images.*'   => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'caption'    => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required'      => 'Judul wajib diisi.',
            'title.string'        => 'Judul harus berupa teks.',
            'title.max'           => 'Judul maksimal :max karakter.',
            'images.required'     => 'Pilih minimal satu gambar.',
            'images.array'        => 'Gambar tidak valid.',
            'images.*.image'      => 'File harus berupa gambar.',
            'images.*.mimes'      => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max'      => 'Ukuran setiap gambar maksimal 5MB.',
            'caption.string'      => 'Keterangan harus berupa teks.',
            'caption.max'         => 'Keterangan maksimal :max karakter.',
            'sort_order.integer'  => 'Urutan harus berupa angka.',
            'sort_order.min'      => 'Urutan minimal 0.',
        ]);

        // Ensure unique sort_order globally
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Gallery::where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        $paths = [];
        foreach ($request->file('images') as $image) {
            $paths[] = $image->store('gallery', 'public');
        }
        $validated['image'] = implode(',', $paths);
        unset($validated['images']);

        Gallery::create($validated);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galeri.form', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'images'     => ['nullable', 'array'],
            'images.*'   => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'caption'    => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'existing_images' => ['nullable', 'string'],
        ], [
            'title.required'        => 'Judul wajib diisi.',
            'title.string'          => 'Judul harus berupa teks.',
            'title.max'             => 'Judul maksimal :max karakter.',
            'images.array'          => 'Gambar tidak valid.',
            'images.*.image'        => 'File harus berupa gambar.',
            'images.*.mimes'        => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max'          => 'Ukuran setiap gambar maksimal 5MB.',
            'caption.string'        => 'Keterangan harus berupa teks.',
            'caption.max'           => 'Keterangan maksimal :max karakter.',
            'sort_order.integer'    => 'Urutan harus berupa angka.',
            'sort_order.min'        => 'Urutan minimal 0.',
            'existing_images.string' => 'Gambar yang sudah ada tidak valid.',
        ]);

        // Ensure unique sort_order globally (exclude current item)
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Gallery::where('id', '!=', $gallery->id)->where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        // Gambar lama: hanya path milik galeri ini yang boleh dipertahankan
        $lama = $this->paths($gallery->image);
        $dipertahankan = array_values(array_intersect($lama, $this->paths($request->input('existing_images', ''))));

        // Gambar baru ditambahkan di belakang gambar lama (bukan menggantikan)
        $baru = [];
        foreach ((array) $request->file('images', []) as $image) {
            $baru[] = $image->store('gallery', 'public');
        }

        $semua = array_merge($dipertahankan, $baru);
        if (empty($semua)) {
            return back()->withInput()->withErrors(['images' => 'Galeri harus memiliki minimal satu gambar.']);
        }
        $validated['image'] = implode(',', $semua);
        unset($validated['images'], $validated['existing_images']);

        $gallery->update($validated);

        // Hapus file gambar lama yang tidak dipakai lagi (setelah data tersimpan)
        foreach (array_diff($lama, $dipertahankan) as $path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    /** "a.jpg, b.jpg" -> ['a.jpg', 'b.jpg'] */
    private function paths(?string $value): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $value))));
    }

    public function destroy(Gallery $gallery)
    {
        // Delete all associated images
        if ($gallery->image) {
            foreach (explode(',', $gallery->image) as $img) {
                Storage::disk('public')->delete(trim($img));
            }
        }
        $gallery->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}
