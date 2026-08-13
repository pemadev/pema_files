<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->when($request->search, fn($q, $v) => $q->where('nama', 'like', "%{$v}%"))
            ->orderBy('sort_order')
            ->paginate(15)
            ->appends(request()->query());

        return view('admin.produk.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.produk.form', [
            'product' => new Product(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'       => ['required', 'string', 'max:255'],
            'vendor'     => ['nullable', 'string', 'max:255'],
            'kategori'   => ['nullable', 'string', 'max:100'],
            'harga'      => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'gambar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'nama.required'   => 'Nama produk wajib diisi.',
            'gambar.image'    => 'File harus berupa gambar.',
            'gambar.mimes'    => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar.max'      => 'Ukuran gambar maksimal :max KB.',
        ]);

        $sortOrder = $validated['sort_order'] ?? 0;
        while (Product::where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.produk.form', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'nama'       => ['required', 'string', 'max:255'],
            'vendor'     => ['nullable', 'string', 'max:255'],
            'kategori'   => ['nullable', 'string', 'max:100'],
            'harga'      => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'gambar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'nama.required'   => 'Nama produk wajib diisi.',
            'gambar.image'    => 'File harus berupa gambar.',
            'gambar.mimes'    => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar.max'      => 'Ukuran gambar maksimal :max KB.',
        ]);

        $sortOrder = $validated['sort_order'] ?? 0;
        while (Product::where('id', '!=', $product->id)->where('sort_order', $sortOrder)->exists()) {
            $sortOrder++;
        }
        $validated['sort_order'] = $sortOrder;

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}