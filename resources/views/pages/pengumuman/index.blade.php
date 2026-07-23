@extends('layouts.app')

@section('title', 'Pengumuman - PT PEMA')
@section('meta_description', 'Pengumuman resmi PT Pembangunan Aceh (PEMA) — Informasi terbaru dan pengumuman resmi perusahaan.')

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
        <div class="absolute top-0 -right-20 w-80 h-80 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="max-w-3xl">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">
                    Informasi
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                <span class="gradient-gold">Pengumuman</span>
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                Informasi dan pengumuman resmi terkait kegiatan, kebijakan, dan perkembangan terbaru PT Pembangunan Aceh (PEMA).
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter -->
<section class="py-8 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" placeholder="Cari pengumuman..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all outline-none">
            </div>
            @if(isset($years) && $years->count() > 0)
            <div>
                <select name="year" class="px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white outline-none">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <button type="submit" class="px-5 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                <i class="fi fi-rs-search"></i>
            </button>
            @if(request('search') || request('year'))
                <a href="{{ url()->current() }}" class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Pengumuman List -->
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($newsList->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($newsList as $news)
                    <article class="group bg-gray-300 rounded-2xl overflow-hidden border border-gray-300 shadow-sm card-hover flex flex-col">
                        <!-- Image -->
                        <a href="#" class="block aspect-[16/10] bg-gray-100 relative overflow-hidden flex-shrink-0">
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}"
                                     alt="{{ $news->title }}"
                                     class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 bg-gray-50">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-orange-50 flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-2xl bg-amber-100 flex items-center justify-center mb-3">
                                        <i class="fi fi-rs-megaphone text-amber-400 text-2xl"></i>
                                    </div>
                                    <p class="text-xs text-amber-300 font-medium">Tidak Ada Gambar</p>
                                </div>
                            @endif
                        </a>

                        <!-- Content -->
                        <div class="p-6 flex flex-col flex-1">
                            <!-- Date & Author -->
                            <div class="flex items-center gap-3 text-xs text-gray-400 mb-2">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fi fi-rs-calendar text-xs"></i>
                                    {{ $news->date ? $news->date->format('d M Y') : '' }}
                                </span>
                                @if($news->author)
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span>{{ $news->author }}</span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h3 class="font-heading font-semibold text-base text-gray-900 mb-3 group-hover:text-pema-500 transition-colors leading-snug">
                                <a href="{{ route('pengumuman.detail', $news) }}">
                                    {{ $news->title }}
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-gray-500 text-sm leading-relaxed mb-4 flex-1">
                                {{ Str::limit(strip_tags($news->content), 200) }}
                            </p>

                            <!-- Read More -->
                            <div class="mt-auto pt-3 border-t border-gray-50">
                                <a href="{{ route('pengumuman.detail', $news) }}"
                                   class="text-pema-500 hover:text-pema-600 font-medium text-sm transition-colors inline-flex items-center gap-1">
                                    Selengkapnya
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

             <!-- Tombol Navigasi Halaman -->
            @if($newsList->hasPages())
    <div class="flex flex-col items-center gap-4 mt-12">
        <p class="text-sm text-gray-500">
            Halaman <span class="font-semibold text-gray-900">{{ $newsList->currentPage() }}</span>
            dari <span class="font-semibold text-gray-900">{{ $newsList->lastPage() }}</span>
        </p>

        <div class="flex justify-center items-center gap-4">
            @if(!$newsList->onFirstPage())
                <a href="{{ $newsList->previousPageUrl() }}" class="btn-nav-prev">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Pengumuman Sebelumnya
                </a>
            @endif

            @if($newsList->hasMorePages())
                <a href="{{ $newsList->nextPageUrl() }}" class="btn-nav-next">
                    Lihat Pengumuman Selanjutnya
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>
    @endif

        @else
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fi fi-rs-document text-gray-300 text-3xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">Belum Ada Pengumuman</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    @if(request('search') || request('year'))
                        Tidak ditemukan pengumuman yang sesuai dengan pencarian Anda.
                    @else
                        Saat ini belum ada pengumuman yang tersedia.
                    @endif
                </p>
                @if(request('search') || request('year'))
                    <a href="{{ url()->current() }}" class="mt-4 inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 font-medium text-sm">
                        <i class="fi fi-rs-cross"></i> Reset Filter
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
