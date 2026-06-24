@extends('layouts.app')

@section('title', 'PT PEMA - PT Pembangunan Aceh')
@section('meta_description', 'Website resmi PT Pembangunan Aceh (PEMA) - Badan Usaha Milik Daerah Aceh.')

@section('content')
<!-- Hero -->
<section class="relative min-h-[85vh] flex items-center bg-pema-900">
    <div class="absolute inset-0 bg-gradient-to-br from-pema-900 via-pema-800 to-pema-900"></div>
    <div class="absolute inset-0 opacity-[0.02]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 80px 80px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 w-full">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/5 text-gold-400 text-xs font-medium rounded-full border border-white/10">
                Badan Usaha Milik Daerah Aceh
            </span>
            <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-heading font-bold text-white leading-[1.1] tracking-tight">
                Menggerakkan Perekonomian
                <span class="text-gold-400">Aceh</span>
                <br>Menuju Masa Depan
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-300 leading-relaxed max-w-xl">
                PT Pembangunan Aceh berkomitmen menjadi penggerak utama pembangunan ekonomi Aceh melalui pengelolaan sumber daya yang profesional, transparan, dan berkelanjutan.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('profil') }}" class="px-5 py-2.5 bg-white text-pema-900 font-medium rounded-lg text-sm hover:bg-gray-100 transition-colors">
                    Tentang Kami
                </a>
                <a href="{{ route('bisnis') }}" class="px-5 py-2.5 border border-white/20 text-white font-medium rounded-lg text-sm hover:bg-white/5 transition-colors">
                    Bidang Bisnis
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Strip -->
<section class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-3 gap-8 py-8">
            <div>
                <p class="text-2xl sm:text-3xl font-heading font-bold text-pema-600">{{ $businesses->flatten()->count() }}</p>
                <p class="text-xs text-gray-400 mt-0.5 uppercase tracking-wider font-medium">Bidang Usaha</p>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-heading font-bold text-pema-600">100%</p>
                <p class="text-xs text-gray-400 mt-0.5 uppercase tracking-wider font-medium">Saham Pemerintah Aceh</p>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-heading font-bold text-pema-600">{{ now()->year - 2016 }}</p>
                <p class="text-xs text-gray-400 mt-0.5 uppercase tracking-wider font-medium">Tahun Berdiri</p>
            </div>
        </div>
    </div>
</section>

<!-- Tentang -->
<section class="py-20 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-gold-500 font-semibold text-xs uppercase tracking-[0.2em]">Profil</span>
                <h2 class="mt-4 text-3xl sm:text-4xl font-heading font-bold text-gray-900 leading-tight">
                    PT Pembangunan Aceh
                </h2>
                <div class="w-12 h-0.5 bg-pema-500 mt-5 mb-6"></div>
                <div class="space-y-4 text-gray-500 leading-relaxed text-sm">
                    <p>PT. Pembangunan Aceh (PEMA) Merupakan Badan Usaha Milik Daerah Aceh (BUMD/BUMA) yang sahamnya 100% dimiliki Pemerintah Aceh, yang bertujuan untuk meningkatkan pembangunan, perekonomian serta Pendapatan Asli Aceh.</p>
                    <p>Website ini merupakan sarana media pelayanan data dan informasi untuk menjembatani keinginan PT PEMA agar lebih dikenal oleh masyarakat melalui media elektronik.</p>
                </div>
                <div class="mt-8 flex items-center gap-6">
                    <a href="{{ route('profil') }}" class="text-sm font-medium text-pema-600 hover:text-pema-700 transition-colors inline-flex items-center gap-1.5">
                        Selengkapnya
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('profil') }}#visi-misi" class="text-sm font-medium text-gray-400 hover:text-gray-600 transition-colors inline-flex items-center gap-1.5">
                        Visi & Misi
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
            <div class="aspect-[4/3] bg-gray-50 rounded-lg overflow-hidden">
                @php
                    $heroImages = ['img/hero/slide-1-migas.jpg', 'img/hero/slide-2-agro.jpg', 'img/hero/slide-3-jasa.jpg', 'storage/downloaded-image.jpeg'];
                    $randImg = $heroImages[array_rand($heroImages)];
                @endphp
                <img src="{{ asset($randImg) }}" alt="PT PEMA" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Business -->
<section class="py-20 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="max-w-2xl">
            <span class="text-gold-500 font-semibold text-xs uppercase tracking-[0.2em]">Bidang Usaha</span>
            <h2 class="mt-3 text-3xl sm:text-4xl font-heading font-bold text-gray-900 leading-tight">
                Program dan Bisnis Kami
            </h2>
            <p class="mt-3 text-gray-400 text-sm">
                Tiga pilar utama yang menjadi fondasi pembangunan ekonomi Aceh.
            </p>
        </div>

        <div class="mt-12 grid md:grid-cols-3 gap-6">
            @php
                $cfg = [
                    'migas' => ['color' => 'bg-pema-500', 'label' => 'Migas', 'icon' => 'fi fi-rs-oil-drip'],
                    'agroindustri' => ['color' => 'bg-emerald-500', 'label' => 'Agroindustri', 'icon' => 'fi fi-rs-seedling'],
                    'jasa' => ['color' => 'bg-amber-500', 'label' => 'Jasa & Perdagangan', 'icon' => 'fi fi-rs-handshake'],
                ];
            @endphp
            @forelse($businesses as $category => $items)
                <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="w-10 h-10 {{ $cfg[$category]['color'] ?? 'bg-pema-500' }} rounded-lg flex items-center justify-center">
                            <i class="{{ $cfg[$category]['icon'] ?? 'fi fi-rs-briefcase' }} text-white text-sm"></i>
                        </div>
                        <h3 class="mt-4 font-heading font-semibold text-gray-900">{{ $cfg[$category]['label'] ?? $category }}</h3>
                        <ul class="mt-4 space-y-2">
                            @foreach($items as $item)
                                <li class="text-sm text-gray-500 flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-gray-300 flex-shrink-0"></span>
                                    {{ $item->title }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="px-6 pb-5">
                        <a href="{{ route('bisnis') }}#{{ $category }}" class="text-xs font-medium text-pema-500 hover:text-pema-600 transition-colors inline-flex items-center gap-1">
                            Selengkapnya
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400 text-sm">Belum ada data bidang usaha.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- News -->
<section class="py-20 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-end justify-between">
            <div>
                <span class="text-gold-500 font-semibold text-xs uppercase tracking-[0.2em]">Informasi</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-heading font-bold text-gray-900 leading-tight">Berita Terbaru</h2>
            </div>
            <a href="{{ route('berita.index') }}" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-pema-500 hover:text-pema-600 transition-colors">
                Lihat Semua
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="mt-10 grid md:grid-cols-3 gap-6">
            @forelse($latestNews as $news)
                <a href="{{ route('berita.detail', $news) }}" class="group block">
                    <div class="aspect-[16/10] bg-gray-50 rounded-lg overflow-hidden">
                        @if($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fi fi-rs-images text-gray-200 text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4">
                        <span class="text-xs text-gray-400">{{ $news->date ? $news->date->format('d M Y') : '' }}</span>
                        <h3 class="mt-1.5 font-heading font-semibold text-gray-900 text-sm leading-snug group-hover:text-pema-600 transition-colors line-clamp-2">
                            {{ $news->title }}
                        </h3>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400 text-sm">Belum ada berita terbaru.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 text-center sm:hidden">
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-pema-500">
                Lihat Semua Berita
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- Partners -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-xl font-heading font-bold text-gray-900">Mitra Kerja Sama</h2>
        </div>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-10 lg:gap-16">
            @forelse($partners as $partner)
                @if($partner->logo)
                    <a href="{{ $partner->website ?: '#' }}" target="{{ $partner->website ? '_blank' : '_self' }}" class="opacity-40 hover:opacity-70 transition-opacity">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-14 w-auto max-w-[180px] object-contain">
                    </a>
                @else
                    <span class="text-sm text-gray-300 font-medium">{{ $partner->name }}</span>
                @endif
            @empty
                <p class="text-gray-400 text-sm">Belum ada data mitra.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
