@extends('layouts.app')

@section('title', 'Agenda - PT PEMA')
@section('meta_description', 'Agenda kegiatan dan acara PT Pembangunan Aceh (PEMA) — Informasi jadwal kegiatan perusahaan.')

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
                    Kegiatan
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                <span class="gradient-gold">Agenda</span> Kegiatan
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                Jadwal kegiatan dan acara PT Pembangunan Aceh (PEMA) yang akan datang maupun yang telah dilaksanakan.
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter -->
<section class="py-8 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" placeholder="Cari judul agenda..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all outline-none">
            </div>
            <div>
                <select name="filter" class="px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white outline-none">
                    <option value="">Semua Status</option>
                    <option value="upcoming" {{ request('filter') === 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                    <option value="past" {{ request('filter') === 'past' ? 'selected' : '' }}>Telah Dilaksanakan</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                <i class="fi fi-rs-search"></i>
            </button>
            @if(request('search') || request('filter'))
                <a href="{{ url()->current() }}" class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Agenda List -->
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($agendaList->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($agendaList as $agenda)
                    @php
                        $past = $agenda->date->isPast();
                    @endphp
                    <article class="group bg-gray-300 rounded-2xl overflow-hidden border border-gray-300 shadow-sm card-hover flex flex-col {{ $past ? 'opacity-60' : '' }}">
                        <!-- Thumbnail -->
                        <div class="block aspect-[16/10] {{ $past ? 'bg-gradient-to-br from-gray-50 to-gray-100' : 'bg-gradient-to-br from-pema-50 to-amber-50' }} relative overflow-hidden flex-shrink-0">
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-2xl {{ $past ? 'bg-gray-200' : 'bg-pema-100' }} flex items-center justify-center mb-3">
                                    <span class="font-heading font-bold text-2xl {{ $past ? 'text-gray-400' : 'text-pema-500' }}">{{ $agenda->date->format('d') }}</span>
                                </div>
                                <p class="text-xs {{ $past ? 'text-gray-400' : 'text-pema-400' }} font-medium">{{ $agenda->date->format('M Y') }}</p>
                            </div>
                            @if(!$past)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-green-500 text-white text-xs font-medium rounded-lg">
                                    Akan Datang
                                </span>
                            @else
                                <span class="absolute top-4 left-4 px-3 py-1 bg-gray-400 text-white text-xs font-medium rounded-lg">
                                    Selesai
                                </span>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fi fi-rs-calendar text-xs"></i>
                                    {{ $agenda->date->format('d M Y') }}
                                </span>
                                @if($agenda->location)
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span class="inline-flex items-center gap-1">
                                        <i class="fi fi-rs-marker text-xs"></i>
                                        {{ Str::limit($agenda->location, 30) }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="font-heading font-semibold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-pema-500 transition-colors">
                                {{ $agenda->title }}
                            </h3>
                            @if($agenda->description)
                                <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4">
                                    {{ $agenda->description }}
                                </p>
                            @else
                                <p class="text-gray-400 text-sm italic mb-4">Tidak ada deskripsi</p>
                            @endif
                            @if($agenda->latitude && $agenda->longitude)
                                <div class="mt-auto pt-3 border-t border-gray-100">
                                    <a href="https://www.google.com/maps?q={{ $agenda->latitude }},{{ $agenda->longitude }}"
                                       target="blank"
                                       class="inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 text-sm font-medium">
                                        <i class="fi fi-rs-map-marker text-sm"></i>
                                        Lihat di PETA
                                    </a>
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($agendaList->hasPages())
                <div class="mt-12">
                    {{ $agendaList->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fi fi-rs-calendar text-gray-300 text-4xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">Belum Ada Agenda</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    Belum ada agenda kegiatan yang tersedia. Silakan kunjungi halaman ini kembali di lain waktu.
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
