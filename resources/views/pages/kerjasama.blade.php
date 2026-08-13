@extends('layouts.app')

@section('title', 'Kerjasama - PT PEMA')
@section('meta_description', 'Informasi kerjasama dan kemitraan PT Pembangunan Aceh (PEMA) — Bersama membangun Aceh melalui sinergi dan kolaborasi strategis.')

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
                    Kemitraan
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                <span class="gradient-gold">Kerjasama</span> & Mitra
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                Sinergi dan kolaborasi strategis dengan berbagai mitra terpercaya untuk mendorong pembangunan dan perekonomian Aceh.
            </p>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Mitra Strategis</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                Mitra Kerja Sama <span class="text-pema-500">PEMA</span>
            </h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto"></div>
            <p class="text-gray-600 mt-6 text-lg">
                PEMA menjalin kemitraan dengan berbagai perusahaan dan institusi terkemuka untuk mewujudkan visi pembangunan Aceh yang berkelanjutan.
            </p>
        </div>

        @if($partners && $partners->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($partners as $partner)
                    <a href="{{ $partner->website ?: '#' }}"
                       target="{{ $partner->website ? '_blank' : '_self' }}"
                       rel="{{ $partner->website ? 'noopener noreferrer' : '' }}"
                       class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">

                        <!-- Frame Foto Logo -->
                        <div class="relative h-56 overflow-hidden bg-gradient-to-br from-pema-100 to-pema-50 flex items-center justify-center p-10">
                            @if($partner->logo)
                                <img src="{{ asset('storage/' . $partner->logo) }}"
                                     alt="{{ $partner->name }}"
                                     class="max-w-full max-h-full object-contain transition-transform duration-500 group-hover:scale-110"
                                     loading="lazy">
                            @else
                                <span class="text-pema-400 font-heading font-semibold text-sm text-center leading-tight">{{ $partner->name }}</span>
                            @endif
                        </div>

                        <!-- Konten -->
                        <div class="bg-gray-100 p-6">

                            <!-- Caption -->
                            <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                                <i class="fi fi-rs-handshake text-gray-400"></i>
                            <span>{{ $partner->caption ?? 'Mitra Kerjasama' }}</span>
                            </div>

                            <!-- Nama Mitra -->
                            <h3 class="font-heading font-bold text-lg text-gray-900">
                                {{ $partner->name }}
                            </h3>
                        </div>

                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 max-w-lg mx-auto">
                <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fi fi-rs-handshake text-gray-300 text-3xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">Belum Ada Data Mitra</h3>
                <p class="text-gray-500">Informasi mitra kerja sama belum tersedia</p>
            </div>
        @endif
    </div>
</section>
@endsection