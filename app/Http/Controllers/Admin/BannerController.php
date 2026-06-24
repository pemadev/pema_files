<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::query()
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->filter === 'active', fn($q) => $q->where('is_active', true))
            ->when($request->filter === 'inactive', fn($q) => $q->where('is_active', false))
            ->orderBy('sort_order')
            ->paginate(15)
            ->appends(request()->query());

        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.form', ['banner' => new Banner()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'      => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'title'      => ['nullable', 'string', 'max:255'],
            'link'       => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ], [
            'image.required'     => 'Gambar wajib diisi.',
            'image.image'        => 'File harus berupa gambar.',
            'image.mimes'        => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max'          => 'Ukuran gambar maksimal :max KB.',
            'title.string'       => 'Judul harus berupa teks.',
            'title.max'          => 'Judul maksimal :max karakter.',
            'link.url'           => 'Format URL tautan tidak valid.',
            'link.max'           => 'URL tautan maksimal :max karakter.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'sort_order.min'     => 'Urutan minimal 0.',
            'is_active.boolean'  => 'Status aktif tidak valid.',
        ]);

        // Ensure unique sort_order globally
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Banner::where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        $validated['image'] = $request->file('image')->store('banners', 'public');
        $validated['is_active'] = $request->boolean('is_active');

        $banner = Banner::create($validated);

        ActivityLogger::log('created', 'banner', 'Menambahkan banner: ' . ($banner->title ?? 'Tanpa judul'), $banner);

        return redirect()->route('admin.banner.index')
            ->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.form', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'image'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'title'      => ['nullable', 'string', 'max:255'],
            'link'       => ['nullable', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ], [
            'image.image'        => 'File harus berupa gambar.',
            'image.mimes'        => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max'          => 'Ukuran gambar maksimal :max KB.',
            'title.string'       => 'Judul harus berupa teks.',
            'title.max'          => 'Judul maksimal :max karakter.',
            'link.url'           => 'Format URL tautan tidak valid.',
            'link.max'           => 'URL tautan maksimal :max karakter.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'sort_order.min'     => 'Urutan minimal 0.',
            'is_active.boolean'  => 'Status aktif tidak valid.',
        ]);

        // Ensure unique sort_order globally (exclude current item)
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Banner::where('id', '!=', $banner->id)->where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        if ($request->hasFile('image')) {
            if ($banner->image) Storage::disk('public')->delete($banner->image);
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $banner->update($validated);

        ActivityLogger::log('updated', 'banner', 'Mengubah banner: ' . ($banner->title ?? 'Tanpa judul'), $banner);

        return redirect()->route('admin.banner.index')
            ->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        $title = $banner->title ?? 'Tanpa judul';
        if ($banner->image) Storage::disk('public')->delete($banner->image);
        $banner->delete();

        ActivityLogger::log('deleted', 'banner', 'Menghapus banner: ' . $title);

        return redirect()->route('admin.banner.index')
            ->with('success', 'Banner berhasil dihapus.');
    }
}
