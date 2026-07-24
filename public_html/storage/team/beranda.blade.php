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
                    <img src="{{ asset($news->image ? 'storage/' . $news->image : 'img/hero/slide-' . (($index % 3) + 1) . '-migas.jpg') }}" alt="{{ $news->title }}" class="w-full h-full object-cover" loading="lazy">
                    <div class="absolute inset-0 hero-overlay"></div>
                </div>

                <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
                    @if($index === 0)
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-heading font-bold text-white leading-tight mb-6">
                            {{ $news->title }}
                        </h1>
                    @else
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-heading font-bold text-white leading-tight mb-6">
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

        <!-- Navigation Dots -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
            <template x-for="(slide, index) in total" :key="index">
                <button @click="active = index"
                        :class="active === index ? 'w-8 h-2.5 bg-gold-500 rounded-full' : 'w-2.5 h-2.5 bg-white/30 hover:bg-white/50 rounded-full'"
                        class="transition-all duration-300 cursor-pointer"
                        :aria-label="'Go to slide ' + (index + 1)">
                </button>
            </template>
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
    </div>
</section>

<!-- About Section -->
<section class="py-20 lg:py-28">
    <div class="mx-auto px-4 sm:px-6 lg:px-16 xl:px-24">
        <div class="grid lg:grid-cols-5 gap-6 items-start">

            <!-- Left: Tentang PEMA (3/5) -->
            <div class="lg:col-span-3 relative rounded-2xl overflow-hidden">
                <!-- Background image -->
                <div class="absolute inset-0">
<img src="{{ asset('img/hero/slide-3-jasa.jpg') }}" alt="Pemandangan kota dan pelabuhan" class="w-full h-full object-cover" loading="lazy">
                    <div class="absolute inset-0 hero-overlay"></div>
                </div>
                <!-- Content -->
            <div class="relative z-10 px-8 py-8 lg:px-12 lg:py-10">
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

            <!-- Right: Poster / Gambar Info -->
            <div class="lg:col-span-2 flex items-center justify-center">
            <div class="rounded-xl overflow-hidden" style="aspect-ratio: 1/1; max-height: 450px; width: auto;">
                <img src="{{ asset('storage/downloaded-image.jpeg') }}" alt="" class="w-full h-full object-cover" loading="lazy">
            </div>
            </div>

    </div>  <!-- close grid -->
</div>  <!-- close container -->
</section>

<!-- Business Highlights -->
<section class="py-20 lg:py-28 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-5xl mx-auto mb-16">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Bidang Usaha</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                Program dan Bisnis Kami
            </h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto"></div>
            <p class="text-gray-600 mt-6 text-lg">
                PEMA bergerak di tiga sektor utama yang menjadi pilar pembangunan ekonomi Aceh.
            </p>
        </div>

        @php
            $categoryConfig = [
                'migas' => [
                    'gradient' => 'from-pema-600 to-pema-500',
                    'iconBg' => 'bg-pema-50',
                    'iconColor' => 'text-pema-500',
                    'iconHoverBg' => 'group-hover:bg-pema-500',
                    'iconHoverColor' => 'group-hover:text-white',
                    'linkColor' => 'text-pema-500',
                    'linkHover' => 'hover:text-pema-600',
                    'icon' => 'fi fi-rs-oil-drip',
                    'label' => 'Migas',
                    'anchor' => 'migas',
                ],
                'agroindustri' => [
                    'gradient' => 'from-green-600 to-green-500',
                    'iconBg' => 'bg-green-50',
                    'iconColor' => 'text-green-600',
                    'iconHoverBg' => 'group-hover:bg-green-500',
                    'iconHoverColor' => 'group-hover:text-white',
                    'linkColor' => 'text-green-600',
                    'linkHover' => 'hover:text-green-700',
                    'icon' => 'fi fi-rs-seedling',
                    'label' => 'Agroindustri',
                    'anchor' => 'agroindustri',
                ],
                'jasa' => [
                    'gradient' => 'from-amber-600 to-amber-500',
                    'iconBg' => 'bg-amber-50',
                    'iconColor' => 'text-amber-600',
                    'iconHoverBg' => 'group-hover:bg-amber-500',
                    'iconHoverColor' => 'group-hover:text-white',
                    'linkColor' => 'text-amber-600',
                    'linkHover' => 'hover:text-amber-700',
                    'icon' => 'fi fi-rs-handshake',
                    'label' => 'Jasa & Perdagangan',
                    'anchor' => 'jasa',
                ],
            ];
        @endphp

        <!-- Business Categories -->
        <div class="grid md:grid-cols-3 gap-8">
            @forelse($businesses as $category => $items)
                @php
                    $cfg = $categoryConfig[$category] ?? [
                        'gradient' => 'from-pema-600 to-pema-500',
                        'iconBg' => 'bg-gray-50',
                        'iconColor' => 'text-pema-500',
                        'iconHoverBg' => 'group-hover:bg-pema-500',
                        'iconHoverColor' => 'group-hover:text-white',
                        'linkColor' => 'text-pema-500',
                        'linkHover' => 'hover:text-pema-600',
                        'icon' => 'fi fi-rs-briefcase',
                        'label' => ucfirst($category),
                        'anchor' => $category,
                    ];
                    $firstItem = $items->first();
                    $allTags = $items->pluck('tags')->flatten()->unique()->filter();
                @endphp
                <div class="group card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                    <div class="h-2 bg-gradient-to-r {{ $cfg['gradient'] }}"></div>
                    <div class="p-8">
                        <div class="w-14 h-14 {{ $cfg['iconBg'] }} rounded-xl flex items-center justify-center mb-6 {{ $cfg['iconHoverBg'] }} transition-colors duration-300">
                            <i class="{{ $cfg['icon'] }} {{ $cfg['iconColor'] }} {{ $cfg['iconHoverColor'] }} text-2xl transition-colors duration-300"></i>
                        </div>
                        <h3 class="font-heading font-bold text-xl text-gray-900 mb-3">{{ $cfg['label'] }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-6">
                            {{ $firstItem ? $firstItem->description : '' }}
                        </p>
                        @if($allTags->isNotEmpty())
                            <ul class="space-y-3">
                                @foreach($allTags as $tag)
                                    <li class="flex items-center gap-3 text-sm text-gray-600">
                                        <span class="w-1.5 h-1.5 bg-gold-500 rounded-full flex-shrink-0"></span>
                                        {{ $tag }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ route('bisnis') }}#{{ $cfg['anchor'] }}" class="inline-flex items-center gap-2 mt-6 {{ $cfg['linkColor'] }} {{ $cfg['linkHover'] }} font-medium text-sm transition-colors">
                            Selengkapnya
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fi fi-rs-briefcase text-gray-300 text-5xl mb-4 inline-block"></i>
                    <p class="text-gray-500">Belum ada data bidang usaha.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('bisnis') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-pema-500 hover:bg-pema-600 text-white font-medium rounded-xl transition-all duration-300">
                Lihat Semua Bidang Usaha
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Quote / Testimonial Section -->
@if($sambutan && $sambutan->additional_info)
<section class="py-20 lg:py-28 bg-pema-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-64 h-64 bg-gold-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-pema-400 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full overflow-hidden border-2 border-gold-500/30">
            <img src="{{ asset('storage/team/foto-direktur.png') }}" alt="Mawardi Nur, SE" class="w-full h-full object-cover">
        </div>
        <i class="fi fi-rs-quote-right text-gold-500 text-4xl mb-6 inline-block opacity-50"></i>
        <blockquote class="text-2xl sm:text-3xl font-heading font-medium text-white leading-relaxed mb-8">
            "{{ $sambutan->additional_info }}"
        </blockquote>
        <div class="w-16 h-0.5 bg-gold-500 mx-auto mb-6"></div>
        @if($sambutan->title)
            <p class="font-heading font-semibold text-white text-lg">{{ $sambutan->title }}</p>
        @endif
        @if($sambutan->content)
            <p class="text-gold-400 text-sm mt-1">{{ Str::limit(strip_tags($sambutan->content), 100) }}</p>
        @endif
    </div>
</section>
@endif

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
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm card-hover">
                    <a href="{{ route('berita.detail', $news) }}" class="block">
                        <div class="aspect-[16/10] bg-gray-100 relative overflow-hidden">
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-pema-500/20 to-pema-700/20"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <i class="fi fi-rs-image text-gray-300 text-4xl"></i>
                                </div>
                            @endif
                            <span class="absolute top-4 left-4 px-3 py-1 bg-pema-500 text-white text-xs font-medium rounded-lg">Berita</span>
                        </div>
                        <div class="p-6">
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
                            <p class="text-gray-500 text-sm line-clamp-3">
                                {{ strip_tags($news->content) }}
                            </p>
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
        <div class="text-center mb-12">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Partner</span>
            <h2 class="text-2xl sm:text-3xl font-heading font-bold text-gray-900 mt-3">Mitra Kerja Sama</h2>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-8 lg:gap-16">
            @forelse($partners as $partner)
                @if($partner->logo)
                    <a href="{{ $partner->website ?: '#' }}" target="{{ $partner->website ? '_blank' : '_self' }}" rel="noopener noreferrer" class="transition-opacity hover:opacity-80">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-16 lg:h-20 w-auto max-w-[200px] object-contain">
                    </a>
                @else
                    <div class="w-24 h-16 bg-gray-200/70 rounded-xl flex items-center justify-center text-gray-400 text-xs font-medium text-center px-2">
                        {{ $partner->name }}
                    </div>
                @endif
            @empty
                <div class="w-full text-center py-8">
                    <i class="fi fi-rs-handshake text-gray-300 text-4xl mb-3 inline-block"></i>
                    <p class="text-gray-500">Belum ada data mitra.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
