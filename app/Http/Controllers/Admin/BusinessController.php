<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->category;
        $query = Business::query()
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->orderBy('sort_order');

        if ($category && in_array($category, ['migas', 'agroindustri', 'jasa'])) {
            $query->where('category', $category);
            $items = $query->paginate(15)->appends(request()->query());
            return view('admin.bisnis.category', compact('items', 'category'));
        }

        $businesses = $query->get()->groupBy('category');
        return view('admin.bisnis.index', compact('businesses'));
    }

    public function create(Request $request)
    {
        $category = $request->category ?? '';
        return view('admin.bisnis.form', [
            'business' => new Business(['category' => $category]),
            'editMode' => false,
            'categoryFromUrl' => in_array($category, ['migas', 'agroindustri', 'jasa']) ? $category : '',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'    => ['required', 'string', 'in:migas,agroindustri,jasa'],
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'images'      => ['nullable', 'array'],
            'images.*'    => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tags'        => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ], [
            'category.required'    => 'Kategori wajib diisi.',
            'category.string'      => 'Kategori harus berupa teks.',
            'category.in'          => 'Kategori harus salah satu dari: migas, agroindustri, atau jasa.',
            'title.required'       => 'Judul wajib diisi.',
            'title.string'         => 'Judul harus berupa teks.',
            'title.max'            => 'Judul maksimal :max karakter.',
            'subtitle.string'      => 'Subtitle harus berupa teks.',
            'subtitle.max'         => 'Subtitle maksimal :max karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.string'   => 'Deskripsi harus berupa teks.',
            'icon.string'          => 'Ikon harus berupa teks.',
            'icon.max'             => 'Ikon maksimal :max karakter.',
            'images.array'         => 'Gambar tidak valid.',
            'images.*.image'       => 'File harus berupa gambar.',
            'images.*.mimes'       => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'images.*.max'         => 'Ukuran gambar maksimal :max KB.',
            'tags.string'          => 'Tag harus berupa teks.',
            'sort_order.integer'   => 'Urutan harus berupa angka.',
            'sort_order.min'       => 'Urutan minimal 0.',
        ]);

        $validated['tags'] = $validated['tags']
            ? array_map('trim', explode(',', $validated['tags']))
            : [];

        // Ensure unique sort_order within category
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Business::where('category', $validated['category'])->where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $img) {
                $paths[] = $img->store('businesses', 'public');
            }
            $validated['images'] = implode(',', $paths);
        }

        Business::create($validated);

        return redirect()->route('admin.bisnis.index', ['category' => $validated['category']])
            ->with('success', 'Bidang bisnis berhasil ditambahkan.');
    }

    public function edit(Business $business, Request $request)
    {
        return view('admin.bisnis.form', [
            'business' => $business,
            'editMode' => true,
            'categoryFromUrl' => $business->category,
        ]);
    }

    public function update(Request $request, Business $business)
    {
        $validated = $request->validate([
            'category'    => ['required', 'string', 'in:migas,agroindustri,jasa'],
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'images'      => ['nullable', 'array'],
            'images.*'    => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tags'        => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'existing_images' => ['nullable', 'string'],
        ], [
            'category.required'    => 'Kategori wajib diisi.',
            'category.string'      => 'Kategori harus berupa teks.',
            'category.in'          => 'Kategori harus salah satu dari: migas, agroindustri, atau jasa.',
            'title.required'       => 'Judul wajib diisi.',
            'title.string'         => 'Judul harus berupa teks.',
            'title.max'            => 'Judul maksimal :max karakter.',
            'subtitle.string'      => 'Subtitle harus berupa teks.',
            'subtitle.max'         => 'Subtitle maksimal :max karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.string'   => 'Deskripsi harus berupa teks.',
            'icon.string'          => 'Ikon harus berupa teks.',
            'icon.max'             => 'Ikon maksimal :max karakter.',
            'images.array'         => 'Gambar tidak valid.',
            'images.*.image'       => 'File harus berupa gambar.',
            'images.*.mimes'       => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'images.*.max'         => 'Ukuran gambar maksimal :max KB.',
            'tags.string'          => 'Tag harus berupa teks.',
            'sort_order.integer'   => 'Urutan harus berupa angka.',
            'sort_order.min'       => 'Urutan minimal 0.',
            'existing_images.string' => 'Gambar yang sudah ada tidak valid.',
        ]);

        $validated['tags'] = $validated['tags']
            ? array_map('trim', explode(',', $validated['tags']))
            : [];

        // Ensure unique sort_order within category (exclude current item)
        $sortOrder = $validated['sort_order'] ?? 0;
        while (Business::where('category', $validated['category'])
            ->where('id', '!=', $business->id)
            ->where('sort_order', $sortOrder)
            ->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $img) {
                $paths[] = $img->store('businesses', 'public');
            }
            $validated['images'] = implode(',', $paths);
        } elseif ($request->filled('existing_images')) {
            $validated['images'] = $request->existing_images;
        } else {
            $validated['images'] = null;
        }
        unset($validated['existing_images']);

        $business->update($validated);

        return redirect()->route('admin.bisnis.index', ['category' => $business->category])
            ->with('success', 'Bidang bisnis berhasil diperbarui.');
    }

    public function destroy(Business $business)
    {
        if ($business->images) {
            foreach (explode(',', $business->images) as $img) {
                Storage::disk('public')->delete(trim($img));
            }
        }
        $category = $business->category;
        $business->delete();

        return redirect()->route('admin.bisnis.index', ['category' => $category])
            ->with('success', 'Bidang bisnis berhasil dihapus.');
    }
}
