@extends('layouts.app')

@section('title', 'Berita - PT PEMA')
@section('meta_description', 'Berita dan informasi terbaru dari PT Pembangunan Aceh (PEMA) — perkembangan terkini seputar kegiatan perusahaan dan pembangunan Aceh.')

@section('content')
<!-- Page Header -->
<section class="relative pt-20 pb-16 lg:pb-20 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 -right-20 w-96 h-96 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 bg-pema-400/20 rounded-full blur-3xl"></div>
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
                <span class="gradient-gold">Berita</span> Terbaru
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                Ikuti perkembangan dan kegiatan terbaru PT Pembangunan Aceh (PEMA) dalam mendorong pembangunan dan perekonomian Aceh.
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter -->
<section class="py-8 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" placeholder="Cari judul berita..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all outline-none">
            </div>
            @if($years && $years->count() > 0)
            <div>
                <select name="year" class="px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white outline-none">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div>
                <select name="sort" onchange="var parts=this.value.split('-');document.getElementById('sort_by').value=parts[0];document.getElementById('sort_dir').value=parts[1];this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white outline-none">
                    <option value="created_at-desc" {{ (request('sort_by', 'created_at') == 'created_at' && request('sort_dir', 'desc') == 'desc') ? 'selected' : '' }}>Terbaru</option>
                    <option value="created_at-asc" {{ (request('sort_by') == 'created_at' && request('sort_dir') == 'asc') ? 'selected' : '' }}>Terlama</option>
                    <option value="title-asc" {{ (request('sort_by') == 'title' && request('sort_dir') == 'asc') ? 'selected' : '' }}>A-Z</option>
                    <option value="title-desc" {{ (request('sort_by') == 'title' && request('sort_dir') == 'desc') ? 'selected' : '' }}>Z-A</option>
                </select>
                <input type="hidden" name="sort_by" id="sort_by" value="{{ request('sort_by', 'created_at') }}">
                <input type="hidden" name="sort_dir" id="sort_dir" value="{{ request('sort_dir', 'desc') }}">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                <i class="fi fi-rs-search"></i>
            </button>
            @if(request('search') || request('year') || request('sort_by'))
                <a href="{{ url()->current() }}" class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>
</section>

<!-- News List -->
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($newsList->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($newsList as $news)
                    <article class="group bg-gray-300 rounded-2xl overflow-hidden border border-gray-100 shadow-sm card-hover flex flex-col">
                        <!-- Thumbnail -->
                        <a href="{{ route('berita.detail', $news) }}" class="bg-gray-100 relative overflow-hidden flex-shrink-0">
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}"
                                     alt="{{ $news->title }}"
                                     class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500 bg-gray-50">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-pema-50 to-blue-50 flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-2xl bg-pema-100 flex items-center justify-center mb-3">
                                        <i class="fi fi-rs-newspaper text-pema-400 text-2xl"></i>
                                    </div>
                                    <p class="text-xs text-pema-300 font-medium">Tidak Ada Gambar</p>
                                </div>
                            @endif
                            @if($news->type)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-pema-500 text-white text-xs font-medium rounded-lg capitalize">
                                    {{ $news->type }}
                                </span>
                            @endif
                        </a>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                <span>{{ $news->date instanceof \Carbon\Carbon ? $news->date->format('d M Y') : \Carbon\Carbon::parse($news->date)->format('d M Y') }}</span>
                                @if($news->author)
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span>{{ $news->author }}</span>
                                @endif
                            </div>
                            <h3 class="font-heading font-semibold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-pema-500 transition-colors">
                                <a href="{{ route('berita.detail', $news) }}">
                                    {{ $news->title }}
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4">
                                {{ Str::limit(strip_tags($news->content), 150) }}
                            </p>
                            <a href="{{ route('berita.detail', $news) }}"
                               class="inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 font-medium text-sm transition-colors group/link mt-auto pt-4">
                                Baca Selengkapnya
                                <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $newsList->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fi fi-rs-newspaper text-gray-300 text-4xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">Belum Ada Berita</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    Belum ada berita yang dipublikasikan saat ini. Silakan kunjungi kembali halaman ini untuk mendapatkan informasi terbaru dari PT PEMA.
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
