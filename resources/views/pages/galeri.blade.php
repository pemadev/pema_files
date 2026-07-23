@extends('layouts.app')

@section('title', 'Galeri - PT PEMA')
@section('meta_description', 'Galeri foto dan dokumentasi kegiatan PT Pembangunan Aceh (PEMA) — Menampilkan momen-momen penting perusahaan.')

@push('styles')
<style>
.card-hover { transition: all 0.3s ease; }
.card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.08); }
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="relative pt-20 pb-16 lg:pb-20 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 -left-20 w-80 h-80 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="max-w-3xl">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">
                    Dokumentasi
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                Galeri <span class="gradient-gold">PEMA</span>
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                Dokumentasi foto kegiatan, acara, dan momen-momen penting PT Pembangunan Aceh (PEMA).
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter -->
<section class="py-8 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" placeholder="Cari galeri..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all outline-none">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                <i class="fi fi-rs-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ url()->current() }}" class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Galeri Grid -->
<section class="py-20 lg:py-28 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($galleries->count() > 0)
            <div x-data="{ open: false, images: [], title: '', index: 0 }"
                 @open-gallery.window="open = true; images = $event.detail.images; title = $event.detail.title; index = 0"
                 @keydown.escape.window="open = false"
                 @keydown.left.window="if(open) index = (index - 1 + images.length) % images.length"
                 @keydown.right.window="if(open) index = (index + 1) % images.length">
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($galleries as $item)
                        @php
                            $imageList = array_map('trim', explode(',', $item->image));
                            $firstImage = $imageList[0] ?? '';
                            $photoCount = count($imageList);
                            $imagesJson = json_encode(array_map(fn($img) => asset('storage/' . $img), $imageList));
                        @endphp
                        <article class="group bg-gray-300 rounded-2xl overflow-hidden border border-gray-100 shadow-sm card-hover flex flex-col cursor-pointer"
                                 @click="images = {{ $imagesJson }}; title = '{{ $item->title }}'; open = true; index = 0">
                            <!-- Cover Image -->
                            <div class=" bg-gray-100 relative overflow-hidden flex-shrink-0">
                                @if($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage) }}"
                                         alt="{{ $item->title ?? 'Foto Galeri' }}"
                                         class="w-full h-full object-contain bg-gray-50 group-hover:scale-105 transition-transform duration-500"
                                         onerror="this.onerror=null;this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%23d1d5db%22><path d=%22M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l2.409-2.409a2.25 2.25 0 013.182 0l2.409 2.409m-3-3.75a3 3 0 11-6 0 3 3 0 016 0z%22/></svg>'">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center bg-gray-100">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l2.409-2.409a2.25 2.25 0 013.182 0l2.409 2.409m-3-3.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-1">
                                @if($item->title)
                                    <h3 class="font-heading font-semibold text-base text-gray-900 mb-2 group-hover:text-pema-500 transition-colors">
                                        {{ $item->title }}
                                    </h3>
                                @endif
                                @if($item->caption)
                                    <p class="text-gray-500 text-sm leading-relaxed flex-1">
                                        {{ $item->caption }}
                                    </p>
                                @endif
                                <div class="mt-3 pt-3 border-t border-gray-50 flex items-center gap-2 text-xs text-gray-400">
                                    <i class="fi fi-rs-picture"></i>
                                    <span>{{ $photoCount }} foto</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($galleries->hasPages())
    <div class="flex flex-col items-center gap-4 mt-12">
        <p class="text-sm text-gray-500">
            Halaman <span class="font-semibold text-gray-900">{{ $galleries->currentPage() }}</span>
            dari <span class="font-semibold text-gray-900">{{ $galleries->lastPage() }}</span>
        </p>

        <div class="flex justify-center items-center gap-4">
            @if(!$galleries->onFirstPage())
                <a href="{{ $galleries->previousPageUrl() }}" class="btn-nav-prev">
                    <i class="fi fi-rs-arrow-left text-lg icon-nav"></i>
                    Galeri Sebelumnya
                </a>
            @endif

            @if($galleries->hasMorePages())
                <a href="{{ $galleries->nextPageUrl() }}" class="btn-nav-next">
                    Lihat Galeri Selanjutnya
                    <i class="fi fi-rs-arrow-right text-lg icon-nav"></i>
                </a>
            @endif
        </div>
    </div>

    <style>
        .btn-nav-next,
        .btn-nav-prev {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            background-color: #2563eb; /* ganti sesuai pema-500 */
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 0.75rem;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .btn-nav-next:hover,
        .btn-nav-prev:hover {
            background-color: #1d4ed8; /* ganti sesuai pema-600 */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .icon-nav {
            display: inline-flex;
            align-items: center;
            line-height: 1;
            position: relative;
            top: 1px;
            transition: transform 0.3s ease;
        }

        .btn-nav-next:hover .icon-nav {
            transform: translateX(4px);
        }

        .btn-nav-prev:hover .icon-nav {
            transform: translateX(-4px);
        }
    </style>
    @endif

                <!-- Lightbox Modal -->
                <template x-teleport="body">
                    <div x-show="open" x-cloak
                         class="fixed inset-0 z-50 bg-black/95 flex flex-col"
                         @click.self="open = false">
                        <!-- Top bar -->
                        <div class="flex items-center justify-between px-4 md:px-6 py-4">
                            <div class="text-white/80 text-sm" x-text="title"></div>
                            <div class="flex items-center gap-4">
                                <span class="text-white/50 text-sm" x-text="(index + 1) + ' / ' + images.length"></span>
                                <button @click="open = false" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Image area -->
                        <div class="flex-1 flex items-center justify-center relative px-4 pb-4">
                            <!-- Prev -->
                            <button @click="index = (index - 1 + images.length) % images.length"
                                    class="absolute left-2 md:left-6 w-10 h-10 md:w-14 md:h-14 rounded-full bg-white/10 hover:bg-white/25 backdrop-blur-md flex items-center justify-center text-white transition-all z-10">
                                <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>

                            <img :src="images[index]" alt="" class="max-h-[75vh] max-w-full object-contain rounded-xl shadow-2xl">

                            <!-- Next -->
                            <button @click="index = (index + 1) % images.length"
                                    class="absolute right-2 md:right-6 w-10 h-10 md:w-14 md:h-14 rounded-full bg-white/10 hover:bg-white/25 backdrop-blur-md flex items-center justify-center text-white transition-all z-10">
                                <svg class="w-5 h-5 md:w-7 md:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>

                            <!-- Thumbnails strip at bottom -->
                            <div class="absolute bottom-0 left-0 right-0 flex justify-center gap-1.5 pb-4 pt-8 bg-gradient-to-t from-black/40 to-transparent pointer-events-none">
                                <template x-for="(img, i) in images" :key="i">
                                    <button @click="index = i"
                                            class="pointer-events-auto w-10 h-8 rounded-lg border-2 transition-all overflow-hidden flex-shrink-0"
                                            :class="i === index ? 'border-white opacity-100' : 'border-transparent opacity-50 hover:opacity-80'">
                                         <img :src="img" alt="" class="w-full h-full object-contain bg-gray-50">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fi fi-rs-picture text-gray-300 text-3xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">Belum Ada Galeri</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    @if(request('search'))
                        Tidak ditemukan galeri yang sesuai dengan pencarian Anda.
                    @else
                        Belum ada foto atau dokumentasi yang tersedia.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ url()->current() }}" class="mt-4 inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 font-medium text-sm">
                        <i class="fi fi-rs-cross"></i> Reset Filter
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
