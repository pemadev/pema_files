@extends('layouts.app')

@section('title', 'PT PEMA - PT Pembangunan Aceh')
@section('meta_description', 'Website resmi PT Pembangunan Aceh (PEMA) - Badan Usaha Milik Daerah Aceh di bidang Migas, Agroindustri, dan Jasa & Perdagangan.')

@section('content')
<!-- Hero Section / Carousel -->
<section class="relative h-screen overflow-hidden bg-pema-800">
    <!-- Background Pattern (shared base layer) -->
    <div class="absolute inset-0 bg-pema-800">
        <div class="absolute inset-0 opacity-[0.03]"
             style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
        </div>
    </div>

    <!-- Carousel -->
    <div x-data="carousel({{ $latestNews->count() }})"
         class="relative h-full w-full"
         @mouseenter="stop()"
         @mouseleave="start()">

        @forelse($latestNews as $index => $news)
            <div x-show="active === {{ $index }}"
                 x-transition:enter.duration.700ms
                 x-transition:leave.duration.700ms
                 class="absolute inset-0 flex items-center justify-center"
                 x-cloak>
                <!-- Slide background image -->
                <div class="absolute inset-0">
                     @if($news->image)
                         <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover" loading="lazy">
                     @else
                         <div class="w-full h-full bg-gradient-to-br from-pema-700 to-pema-900"></div>
                     @endif
                    <div class="absolute inset-0 hero-overlay"></div>
                </div>

                <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
                    @if($index === 0)
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white leading-tight mb-6">
                            {{ $news->title }}
                        </h1>
                    @else
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white leading-tight mb-6">
                            {{ $news->title }}
                        </h2>
                    @endif
                    <p class="text-lg text-gray-300 leading-relaxed max-w-2xl mx-auto mb-8">
                        {{ strip_tags($news->content) ? Str::limit(strip_tags($news->content), 200) : '' }}
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('berita.detail', $news) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gold-500 hover:bg-gold-600 text-pema-800 font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-gold-500/25">
                            Baca Berita
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-heading font-bold text-white leading-tight mb-6">
                        Selamat Datang di
                        <span class="gradient-gold">PT PEMA</span>
                    </h1>
                    <p class="text-lg text-gray-300 leading-relaxed max-w-2xl mx-auto">
                        Website resmi PT Pembangunan Aceh — Badan Usaha Milik Daerah Aceh.
                    </p>
                </div>
            </div>
        @endforelse

        @if($latestNews->count() > 1)
        <!-- Navigation Dots -->
        <div class="absolute bottom-8 left-0 right-0 z-20 flex justify-center items-center" style="gap: 8px;">
            @foreach($latestNews as $index => $news)
                <button onclick="active = {{ $index }}"
                        style="width: 12px; height: 12px; border-radius: 9999px; cursor: pointer; border: none; padding: 0;"
                        :style="active === {{ $index }} ? 'background-color: #C4923C;' : 'background-color: rgba(209, 213, 219, 0.7);'"
                        aria-label="Go to slide {{ $index + 1 }}">
                </button>
            @endforeach
        </div>

        <!-- Prev Button -->
        <button @click="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/20 hover:border-gold-500/50 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Next Button -->
        <button @click="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/20 hover:border-gold-500/50 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        @endif
    </div>
</section>

<!-- About Section -->
<section class="py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-5 gap-6 lg:items-stretch">

            <!-- Left: Tentang PEMA (3/5) -->
            <div class="lg:col-span-3 relative rounded-2xl overflow-hidden flex flex-col min-h-[300px] lg:min-h-0">
                <!-- Background image -->
                <div class="absolute inset-0">
<img src="{{ asset('img/hero/slide-3-jasa.jpg') }}" alt="Pemandangan kota dan pelabuhan" class="w-full h-full object-cover" loading="lazy">
                    <div class="absolute inset-0 hero-overlay"></div>
                </div>
                <!-- Content -->
            <div class="relative z-10 px-8 py-8 lg:px-12 lg:py-10 flex-1 flex flex-col justify-center">
                <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Profil PT PEMA</span>
                <h2 class="text-2xl sm:text-3xl font-heading font-bold text-white mt-2 mb-4">
                    PT Pembangunan Aceh
                </h2>
                <div class="w-12 h-0.5 bg-gold-500 rounded-full mb-5"></div>
                        <p class="text-gray-200 leading-relaxed text-sm max-w-3xl">
                            PT. Pembangunan Aceh (PEMA) Merupakan Badan Usaha Milik Daerah Aceh (BUMD/BUMA) yang sahamnya 100% dimiliki Pemerintah Aceh, yang bertujuan untuk meningkatkan pembangunan, perekonomian serta Pendapatan Asli Aceh.
                        </p>
                        <p class="text-gray-200 leading-relaxed text-sm mt-4 max-w-3xl">
                            Website ini merupakan sarana media pelayanan data dan informasi untuk menjembatani keinginan PT PEMA agar lebih dikenal oleh masyarakat melalui media elektronik.
                        </p>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('profil') }}#visi-misi" class="inline-flex items-center gap-2 px-6 py-3 bg-gold-500 hover:bg-gold-600 text-pema-800 font-semibold rounded-xl transition-all duration-300">
                        VISI dan MISI
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>  <!-- close left column -->

            <!-- Right: Poster / Banner Carousel -->
            <div class="lg:col-span-2 flex flex-col" x-data="{ current: 0, total: {{ $banners->count() ?: 1 }}, timer: null }"
                 x-init="if(total > 1) timer = setInterval(() => { current = (current + 1) % total }, 4000)">
                @if($banners->count() > 0)
                    <div class="relative rounded-2xl overflow-hidden bg-gray-100 w-full" style="aspect-ratio: 1/1;">
                        @foreach($banners as $i => $banner)
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? '' }}"
                                 x-show="current === {{ $i }}"
                                 x-transition:enter="transition ease-out duration-700"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-700"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; background-color: #f9fafb; border-radius: 16px;">
                        @endforeach

                        @if($banners->count() > 1)
                            <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: space-between; pointer-events: none; padding: 0 12px; z-index: 10;">
                                <button @click="clearInterval(timer); current = (current - 1 + total) % total; timer = setInterval(() => { current = (current + 1) % total }, 4000)"
                                        style="pointer-events: auto; width: 32px; height: 32px; border-radius: 9999px; background: rgba(255,255,255,0.9); display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15); border: none; cursor: pointer;">
                                    <svg style="width: 16px; height: 16px; fill: none; stroke: #1f2937; stroke-width: 2;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <button @click="clearInterval(timer); current = (current + 1) % total; timer = setInterval(() => { current = (current + 1) % total }, 4000)"
                                        style="pointer-events: auto; width: 32px; height: 32px; border-radius: 9999px; background: rgba(255,255,255,0.9); display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15); border: none; cursor: pointer;">
                                    <svg style="width: 16px; height: 16px; fill: none; stroke: #1f2937; stroke-width: 2;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>

                            <div style="position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; z-index: 10;">
                                @foreach($banners as $i => $banner)
                                    <button @click="clearInterval(timer); current = {{ $i }}; timer = setInterval(() => { current = (current + 1) % total }, 4000)"
                                            :style="current === {{ $i }} ? 'background-color: #C4923C;' : 'background-color: rgba(209,213,219,0.7);'"
                                            style="width: 12px; height: 12px; border-radius: 9999px; border: none; cursor: pointer; padding: 0;"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div style="border-radius: 16px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; height: 300px; color: #9ca3af; font-size: 14px;">Belum ada banner</div>
                @endif
            </div>
            </div>

    </div>  <!-- close grid -->
</div>  <!-- close container -->
</section>

<!-- Section Video YouTube -->
<section class="pt-16 pb-20 bg-white">   
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Video Profil</span>
            <h2 class="text-2xl sm:text-3xl font-heading font-bold text-gray-900 mt-3">Mengenal PT PEMA Lebih Dekat</h2>
        </div>
        <div class="relative w-full rounded-2xl overflow-hidden shadow-lg" style="padding-bottom: 56.25%;">
            <iframe
                class="absolute top-0 left-0 w-full h-full"
                src="https://www.youtube.com/embed/2rZShiJEEbU"
                title="Video Profil PT PEMA"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </div>
</section>

<!-- Business Highlights -->
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12">
            <div>
                <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Bidang Usaha</span>
                <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3">Program dan Bisnis Kami</h2>
            </div>
            <a href="{{ route('bisnis') }}" class="inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 font-medium text-sm transition-colors">
                Lihat Semua Bidang Usaha
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        @php
            $categoryConfig = [
                'migas' => [
                    'gradient' => 'from-pema-600 to-pema-500',
                    'bg' => 'bg-blue-50',
                    'text' => 'text-blue-600',
                    'icon' => 'fi fi-rs-gas-pump',
                    'label' => 'Migas',
                ],
                'agroindustri' => [
                    'gradient' => 'from-green-600 to-green-500',
                    'bg' => 'bg-green-50',
                    'text' => 'text-green-600',
                    'icon' => 'fi fi-rs-seedling',
                    'label' => 'Agroindustri',
                ],
                'jasa' => [
                    'gradient' => 'from-amber-600 to-amber-500',
                    'bg' => 'bg-amber-50',
                    'text' => 'text-amber-600',
                    'icon' => 'fi fi-rs-handshake',
                    'label' => 'Jasa & Perdagangan',
                ],
            ];
        @endphp

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($businesses as $category => $items)
                @php
                    $cfg = $categoryConfig[$category] ?? [
                        'gradient' => 'from-pema-600 to-pema-500',
                        'bg' => 'bg-gray-50',
                        'text' => 'text-gray-600',
                        'icon' => 'fi fi-rs-briefcase',
                        'label' => ucfirst($category),
                    ];
                    $firstItem = $items->first();
                @endphp
                <a href="{{ route('bisnis.category', $category) }}" class="group bg-gray-300 rounded-2xl overflow-hidden border border-gray-100 shadow-sm card-hover">
                    <div class="aspect-[16/10] relative overflow-hidden">
                        @if($firstItem && $firstItem->images)
                            @php $firstImg = trim(explode(',', $firstItem->images)[0]); @endphp
                            @if($firstImg)
                                <img src="{{ asset('storage/' . $firstImg) }}" alt="{{ $cfg['label'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 {{ $cfg['bg'] }} flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-2xl bg-white/50 flex items-center justify-center mb-3">
                                        <i class="{{ $cfg['icon'] }} {{ $cfg['text'] }} text-2xl"></i>
                                    </div>
                                    <p class="text-xs text-gray-400 font-medium">Tidak ada gambar</p>
                                </div>
                            @endif
                        @elseif($firstItem && $firstItem->image)
                            <img src="{{ asset('storage/' . $firstItem->image) }}" alt="{{ $cfg['label'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 {{ $cfg['bg'] }} flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-2xl bg-white/50 flex items-center justify-center mb-3">
                                    <i class="{{ $cfg['icon'] }} {{ $cfg['text'] }} text-2xl"></i>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">Tidak ada gambar</p>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 px-3 py-1 {{ $cfg['bg'] }} {{ $cfg['text'] }} text-xs font-medium rounded-lg z-10">
                            {{ $cfg['label'] }}
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-heading font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-pema-500 transition-colors">
                            {{ $firstItem ? $firstItem->title : $cfg['label'] }}
                        </h3>
                        <p class="text-gray-500 text-sm line-clamp-3">
                            {{ $firstItem ? strip_tags($firstItem->description) : '' }}
                        </p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="text-pema-500 text-sm font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                                Lihat Detail
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fi fi-rs-briefcase text-gray-300 text-5xl mb-4 inline-block"></i>
                    <p class="text-gray-500">Belum ada data bidang usaha.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Quote / Testimonial Section -->
<section class="py-12 lg:py-16 bg-pema-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-64 h-64 bg-gold-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-pema-400 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-40 h-40 mx-auto mb-6 rounded-full overflow-hidden border-2 border-gold-500/30">
             <img src="{{ asset('storage/team/foto-direktur.png') }}" alt="Mawardi Nur, SE" class="w-full h-full object-contain bg-gray-50">
        </div>
        <i class="fi fi-rs-quote-right text-gold-500 text-4xl mb-6 inline-block opacity-50"></i>
        <blockquote class="text-2xl sm:text-2xl font-heading font-medium text-white leading-relaxed mb-4">
            "PT PEMA hadir sebagai  Badan Usaha Milik Aceh (BUMA) dengan kepemilikan saham penuh oleh Pemerintah Aceh. Sejak resmi berdiri pada 05 April 2019, PT PEMA mengemban mandat strategis untuk mengoptimalkan potensi dan sumber daya daerah"
        </blockquote>
        <div class="w-16 h-0.5 bg-gold-500 mx-auto mb-6"></div>
        <p class="font-heading font-semibold text-white text-lg">Mawardi Nur, SE</p>
        <p class="text-gold-400 text-sm mt-1">Direktur Utama</p>
        <p class="text-gold-400 text-sm mt-1">PT Pembangunan Aceh (Perseroda)</p>
        <div class="mt-4 mb-4">
            <a href="{{ route('profil') }}#sambutan" class="group inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-gold-500 text-pema-900 text-base font-bold hover:bg-gold-400 transition-colors duration-300">
                Sambutan Direktur
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform duration-300 group-hover:animate-arrow-slide" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>

<style>
    @keyframes arrow-slide {
        0%   { transform: translateX(0); }
        50%  { transform: translateX(6px); }
        100% { transform: translateX(0); }
    }
    .group:hover .group-hover\:animate-arrow-slide {
        animation: arrow-slide 0.8s ease-in-out infinite;
    }
</style>


<!-- News Highlights -->
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12">
            <div>
                <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Informasi</span>
                <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3">Berita Terbaru</h2>
            </div>
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 font-medium text-sm transition-colors">
                Lihat Semua Berita
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($latestNews as $news)
                <div class="group bg-gray-300 rounded-2xl overflow-hidden border border-gray-300 shadow-sm card-hover flex flex-col">
                    <a href="{{ route('berita.detail', $news) }}" class="block">
                        <div class="bg-gray-100 relative overflow-hidden">
                            @if($news->image)
                                 <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-contain bg-gray-50 group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-pema-50 to-blue-50 flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-2xl bg-pema-100 flex items-center justify-center mb-3">
                                        <i class="fi fi-rs-newspaper text-pema-400 text-2xl"></i>
                                    </div>
                                    <p class="text-xs text-pema-300 font-medium">Tidak ada gambar</p>
                                </div>
                            @endif
                            <span class="absolute top-4 left-4 px-3 py-1 bg-pema-500 text-white text-xs font-medium rounded-lg">Berita</span>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                <span>{{ $news->date ? $news->date->format('d M Y') : '' }}</span>
                                @if($news->author)
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span>{{ $news->author }}</span>
                                @endif
                            </div>
                            <h3 class="font-heading font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-pema-500 transition-colors">
                                {{ $news->title }}
                            </h3>
                            <p class="text-gray-500 text-sm line-clamp-3 flex-1">
                                {{ strip_tags($news->content) }}
                            </p>
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <span class="text-pema-500 text-sm font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                                    Lihat Detail
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fi fi-rs-newspaper text-gray-300 text-5xl mb-4 inline-block"></i>
                    <p class="text-gray-500">Belum ada berita terbaru.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Partners -->
<section class="py-16 lg:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12">
            <div>
                <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Partner</span>
                <h2 class="text-2xl sm:text-3xl font-heading font-bold text-gray-900 mt-3">Mitra Kerja Sama</h2>
            </div>
        </div>

        @if($partners->whereNotNull('logo')->count() > 0)
            <div id="partner-splide" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($partners->whereNotNull('logo') as $partner)
                            <li class="splide__slide">
                                <a href="{{ $partner->website ?: '#' }}" target="{{ $partner->website ? '_blank' : '_self' }}" rel="noopener noreferrer" class="block bg-white rounded-xl shadow-sm hover:shadow-md transition-all aspect-square flex items-center justify-center p-2 sm:p-3 mx-auto" style="max-width: 140px; max-height: 140px;">
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="w-full h-full object-contain p-1">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fi fi-rs-handshake text-gray-300 text-4xl mb-3 inline-block"></i>
                <p class="text-gray-500">Belum ada data mitra.</p>
            </div>
        @endif
    </div>
</section>
@endsection