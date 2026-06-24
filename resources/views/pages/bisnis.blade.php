@extends('layouts.app')

@section('title', 'Bidang Bisnis - PT PEMA')
@section('meta_description', 'PT Pembangunan Aceh (PEMA) bergerak di tiga sektor bisnis utama: Migas, Agroindustri, serta Jasa & Perdagangan.')

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
                    Bidang Usaha
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                Program dan <span class="gradient-gold">Bisnis Kami</span>
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                PT PEMA mengelola tiga pilar bisnis utama yang menjadi fondasi pembangunan ekonomi Aceh.
            </p>
        </div>
    </div>
</section>

<!-- Category Cards -->
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                Pilih <span class="text-pema-500">Bidang Bisnis</span>
            </h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto"></div>
        </div>

        @php
            $colorMap = [
                'pema' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'hover' => 'hover:border-blue-200'],
                'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'hover' => 'hover:border-green-200'],
                'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'hover' => 'hover:border-amber-200'],
            ];
        @endphp

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $key => $cat)
                @php $c = $colorMap[$cat['color']]; @endphp
                <a href="{{ route('bisnis.category', $key) }}"
                   class="bg-gray-300 rounded-2xl border border-gray-100 shadow-sm p-8 hover:shadow-lg {{ $c['hover'] }} transition-all duration-300 group">
                    <div class="w-16 h-16 rounded-2xl {{ $c['bg'] }} flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <i class="{{ $cat['icon'] }} {{ $c['text'] }} text-3xl"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">{{ $cat['label'] }}</h3>
                    <p class="text-sm text-gray-400 mb-5">{{ $cat['desc'] }}</p>
                    <span class="text-pema-500 text-sm font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                        Lihat Detail <i class="fi fi-rs-arrow-right text-sm"></i>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
