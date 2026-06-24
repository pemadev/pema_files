@extends('layouts.app')

@php
    $colorMap = [
        'pema' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'badge' => 'bg-blue-500', 'line' => 'bg-blue-500', 'hover' => 'hover:border-blue-200'],
        'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'badge' => 'bg-green-500', 'line' => 'bg-green-500', 'hover' => 'hover:border-green-200'],
        'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'badge' => 'bg-amber-500', 'line' => 'bg-amber-500', 'hover' => 'hover:border-amber-200'],
    ];
    $c = $colorMap[$cat['color']];
@endphp

@section('title', $cat['label'] . ' - PT PEMA')
@section('meta_description', $cat['desc'] . ' — PT Pembangunan Aceh (PEMA).')

@push('styles')
<style>
.card-hover { transition: all 0.3s ease; }
.card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.08); }
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="relative pt-20 pb-12 lg:pb-16 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 -left-20 w-80 h-80 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="animate-fade-in-up mb-6">
            <a href="{{ route('bisnis') }}"
               class="inline-flex items-center gap-2 text-gray-300 hover:text-gold-400 text-sm transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                Semua Bidang Bisnis
            </a>
        </div>

        <div class="max-w-3xl">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">
                    {{ $cat['label'] }}
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                {{ $cat['label'] }}
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                {{ $cat['desc'] }}
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter -->
<section class="py-8 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3 items-end">
            <input type="hidden" name="category" value="{{ $category }}">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" placeholder="Cari judul bisnis..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all outline-none">
            </div>
            <div>
                <select name="sort" onchange="var parts=this.value.split('-');document.getElementById('sort_by').value=parts[0];document.getElementById('sort_dir').value=parts[1];this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white outline-none">
                    <option value="sort_order-asc" {{ (request('sort_by', 'sort_order') == 'sort_order' && request('sort_dir', 'asc') == 'asc') ? 'selected' : '' }}>Urutan</option>
                    <option value="title-asc" {{ (request('sort_by') == 'title' && request('sort_dir') == 'asc') ? 'selected' : '' }}>A-Z</option>
                    <option value="title-desc" {{ (request('sort_by') == 'title' && request('sort_dir') == 'desc') ? 'selected' : '' }}>Z-A</option>
                    <option value="created_at-desc" {{ (request('sort_by') == 'created_at' && request('sort_dir') == 'desc') ? 'selected' : '' }}>Terbaru</option>
                    <option value="created_at-asc" {{ (request('sort_by') == 'created_at' && request('sort_dir') == 'asc') ? 'selected' : '' }}>Terlama</option>
                </select>
                <input type="hidden" name="sort_by" id="sort_by" value="{{ request('sort_by', 'sort_order') }}">
                <input type="hidden" name="sort_dir" id="sort_dir" value="{{ request('sort_dir', 'asc') }}">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                <i class="fi fi-rs-search"></i>
            </button>
            @if(request('search') || request('sort_by'))
                <a href="{{ url()->current() }}" class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Items Grid -->
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($items->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($items as $item)
                    <a href="{{ route('bisnis.detail', ['category' => $category, 'business' => $item]) }}" class="bg-gray-300 rounded-2xl overflow-hidden border border-gray-100 shadow-sm card-hover flex flex-col">
                        @if($item->images)
                            @php $firstImg = trim(explode(',', $item->images)[0]); @endphp
                            @if($firstImg)
                            <div class="aspect-[16/10] relative overflow-hidden flex-shrink-0">
                                <img src="{{ asset('storage/' . $firstImg) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            @else
                            <div class="aspect-[16/10] {{ $c['bg'] }} relative overflow-hidden flex-shrink-0 flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-2xl bg-white/50 flex items-center justify-center mb-3">
                                    <i class="{{ $cat['icon'] }} {{ $c['text'] }} text-2xl"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">Tidak ada gambar</p>
                            </div>
                            @endif
                        @elseif($item->image)
                            <div class="aspect-[16/10] relative overflow-hidden flex-shrink-0">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-500">
                            </div>
                        @else
                            <div class="aspect-[16/10] {{ $c['bg'] }} relative overflow-hidden flex-shrink-0 flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-2xl bg-white/50 flex items-center justify-center mb-3">
                                    <i class="{{ $cat['icon'] }} {{ $c['text'] }} text-2xl"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">Tidak ada gambar</p>
                            </div>
                        @endif

                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="font-heading font-semibold text-base text-gray-900 mb-3 group-hover:text-pema-500 transition-colors">
                                {{ $item->title }}
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-4 flex-1 line-clamp-3">
                                {{ Str::limit(strip_tags($item->description), 150) }}
                            </p>
                            @if(!empty($item->tags))
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    @foreach($item->tags as $tag)
                                        <span class="px-2.5 py-0.5 text-xs font-medium bg-gray-50 text-gray-500 rounded-lg">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="mt-auto pt-3 border-t border-gray-100">
                                <span class="text-pema-500 text-sm font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                                    Lihat Selengkapnya
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $items->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="{{ $cat['icon'] }} text-gray-400 text-2xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">Belum Ada Data</h3>
                <p class="text-gray-500 max-w-md mx-auto">Data bisnis {{ strtolower($cat['label']) }} akan segera tersedia.</p>
                <a href="{{ route('bisnis') }}" class="mt-4 inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 font-medium text-sm">
                    <i class="fi fi-rs-arrow-left"></i> Kembali
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
