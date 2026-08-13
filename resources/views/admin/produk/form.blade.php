@extends('admin.layouts.master')

@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')
@section('page_title', $product->exists ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">
            {{ $product->exists ? 'Perbarui data produk vendor' : 'Tambahkan produk vendor baru' }}
        </p>
        <a href="{{ route('admin.produk.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
            <i class="fi fi-rs-arrow-left text-sm"></i>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                <i class="fi fi-rs-shopping-bag text-green-500 text-sm"></i>
            </div>
            <h3 class="font-heading font-semibold text-gray-900 text-sm">
                {{ $product->exists ? 'Form Edit Produk' : 'Form Tambah Produk' }}
            </h3>
        </div>

        <form method="POST"
              action="{{ $product->exists ? route('admin.produk.update', $product) : route('admin.produk.store') }}"
              enctype="multipart/form-data"
              class="p-5 space-y-5">
            @csrf
            @if($product->exists)
                @method('PUT')
            @endif

            <!-- Nama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $product->nama) }}" required
                       placeholder="Contoh: Kopi Gayo Arabika"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('nama') border-red-300 @enderror">
                @error('nama')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Vendor -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Vendor / UMKM</label>
                <input type="text" name="vendor" value="{{ old('vendor', $product->vendor) }}"
                       placeholder="Contoh: UMKM Mitra Tani Aceh Tengah"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('vendor') border-red-300 @enderror">
                @error('vendor')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $product->kategori) }}"
                       placeholder="Contoh: Kuliner, Kerajinan"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('kategori') border-red-300 @enderror">
                @error('kategori')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga</label>
                <input type="text" name="harga" value="{{ old('harga', $product->harga) }}"
                       placeholder="Contoh: Rp 85.000 / 250gr"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('harga') border-red-300 @enderror">
                @error('harga')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Urutan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Urutan Tampil</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}"
                       placeholder="0"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('sort_order') border-red-300 @enderror">
                <p class="text-xs text-gray-400 mt-1">Angka lebih kecil akan tampil lebih dulu.</p>
                @error('sort_order')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Gambar Produk</label>

                @if($product->exists && $product->gambar)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ Storage::url($product->gambar) }}"
                             alt="{{ $product->nama }}"
                             class="w-16 h-16 rounded-lg object-cover bg-white border border-gray-100">
                        <span class="text-xs text-gray-400">Gambar saat ini</span>
                    </div>
                @endif

                <input type="file" name="gambar" accept="image/*"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-pema-50 file:text-pema-600 hover:file:bg-pema-100 @error('gambar') border-red-300 @enderror">
                <p class="text-xs text-gray-400 mt-1">Format PNG/JPG, disarankan rasio 4:3 (landscape).</p>
                @error('gambar')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.produk.index') }}"
                   class="px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fi fi-rs-check text-sm"></i>
                    {{ $product->exists ? 'Simpan Perubahan' : 'Simpan Produk' }}
                </button>
            </div>

        </form>
    </div>

</div>
@endsection