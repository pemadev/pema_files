@extends('layouts.app')

@section('title', 'Produk Vendor - PT PEMA')
@section('meta_description', 'Jelajahi produk unggulan dari mitra vendor PT Pembangunan Aceh (PEMA).')

@section('content')
<!-- Page Header -->
<section class="relative pt-20 pb-16 lg:pb-20 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 -right-20 w-80 h-80 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">
                Vendor
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                Produk <span class="gradient-gold">Vendor</span>
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl">
                Produk unggulan dari mitra vendor yang bekerja sama dengan PT Pembangunan Aceh (PEMA).
            </p>
        </div>
    </div>
</section>


<!-- Produk Vendor -->
<section class="py-20 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-8 sm:px-6 lg:px-14">

        <!-- Banner Ajakan Daftar Vendor -->
        <div class="bg-pema-800 rounded-2xl p-6 sm:p-8 mb-16 flex flex-col sm:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <div class="absolute top-14 right-0 w-20 h-20 bg-gold-500/20 rounded-full blur-3xl"></div>

            <div class="relative">
                <p class="text-white font-medium text-base sm:text-lg leading-relaxed">
                    Silakan daftar menjadi vendor PT Pembangunan Aceh, klik link registrasi berikut.
                </p>
            </div>

            <a href="https://ivds.pema.co.id/" target="_blank"
                    class="relative flex-shrink-0 inline-flex items-center gap-2 px-6 py-3 bg-gold-500 hover:bg-gold-400 text-pema-900 text-sm font-semibold rounded-xl whitespace-nowrap"
                    style="transition: background-color 0.3s;">
                <span>Registrasi Vendor</span>
                <i class="fi fi-rs-arrow-right text-sm" style="transition: transform 0.3s ease-out; display: inline-flex; align-items: center; line-height: 1;"></i>
            </a>
        </div>

        <!-- Heading Katalog -->
        <div class="mb-14">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Katalog</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                {{ $products->count() }} Produk <span class="text-pema-500">Unggulan</span>
            </h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full"></div>
        </div>

        <!-- Grid Produk -->
        @if($products && $products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $produk)
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300">

                    <!-- Gambar -->
                    <div class="relative h-56 overflow-hidden bg-gray-100">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}"
                                 alt="{{ $produk->nama }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pema-100 to-pema-50">
                                <span class="text-pema-400 text-xs">Gambar belum diunggah</span>
                            </div>
                        @endif
                    </div>

                    <!-- Konten -->
                    <div class="bg-gray-300 p-6">

                        <!-- Icon + Kategori + Vendor -->
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                            <i class="fi fi-rs-tag text-gray-400"></i>
                            <span>{{ $produk->kategori ?? '-' }}</span>
                            <span class="text-gray-300">•</span>
                            <span>{{ $produk->vendor ?? '-' }}</span>
                        </div>

                        <!-- Nama Produk -->
                        <h3 class="font-heading font-bold text-lg text-gray-900 mb-2">
                            {{ $produk->nama }}
                        </h3>

                        <!-- Harga -->
                        <p class="text-sm text-gray-500">
                            {{ $produk->harga ?? '-' }}
                        </p>

                    </div>

                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 max-w-lg mx-auto">
                <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fi fi-rs-shopping-bag text-gray-300 text-3xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">Belum Ada Produk</h3>
                <p class="text-gray-500">Produk unggulan vendor belum tersedia</p>
            </div>
        @endif

    </div><!-- /max-w-7xl -->
</section><!-- /Produk Vendor -->

<!-- CSS tambahan untuk animasi tombol Registrasi Vendor -->
<style>
    a:hover i.fi-rs-arrow-right {
        transform: translateX(4px);
    }
</style>

@endsection