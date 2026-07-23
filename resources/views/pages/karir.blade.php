@extends('layouts.app')

@section('title', 'Karir - PT PEMA')
@section('meta_description', 'Informasi karir dan lowongan pekerjaan terbaru di PT Pembangunan Aceh (PEMA) — Bergabunglah bersama kami untuk membangun Aceh.')

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
                    Karir
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                <span class="gradient-gold">Karir</span> di PEMA
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                Bergabunglah bersama PT Pembangunan Aceh (PEMA) dan jadilah bagian dari tenaga profesional yang berkomitmen memajukan perekonomian Aceh.
            </p>
        </div>
    </div>
</section>

<!-- Registration Section -->
<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Peluang Karir</span>
                <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                    Daftar <span class="text-pema-500">Sekarang</span>
                </h2>
                <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto mb-6"></div>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Bergabunglah bersama PT Pembangunan Aceh (PEMA) dan jadilah bagian dari tenaga profesional yang berkomitmen memajukan perekonomian Aceh.
                </p>
            </div>

            <!-- Registration Link -->
            <div class="bg-gradient-to-br from-pema-500 to-pema-600 rounded-2xl p-8 lg:p-12 text-center text-white">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fi fi-rs-paper-plane text-white text-3xl"></i>
                </div>
                <h3 class="font-heading font-bold text-2xl mb-4">Formulir Pendaftaran</h3>
                <p class="text-white/80 mb-8 max-w-lg mx-auto">
                    Isi formulir pendaftaran untuk bergabung bersama kami. Pastikan data yang diisi sudah benar dan lengkap.
                </p>
                @if($karirLink && $karirLink !== '#')
                    <a href="{{ $karirLink }}" 
                        target="_blank"
                        class="btn-daftar">
                        Isi Formulir Pendaftaran
                        <i class="fi fi-rs-arrow-right text-lg icon-daftar"></i>
                    </a>

                <style>
    .btn-daftar {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background-color: white;
        color: #1d4ed8;
        font-weight: 600;
        border-radius: 0.75rem;
        transition: background-color 0.3s ease;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }

    .btn-daftar:hover {
        background-color: #f9fafb;
    }

    .icon-daftar {
        display: inline-flex;
        align-items: center;
        line-height: 1;
        position: relative;
        top: 1px; /* turunkan sedikit agar sejajar dengan teks */
        transition: transform 0.3s ease;
    }

    .btn-daftar:hover .icon-daftar {
        transform: translateX(4px);
    }
                </style>
                @else
                    <p class="text-white/60 text-sm italic">Link pendaftaran belum tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-16 lg:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Mengapa PEMA?</span>
                <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                    Bergabung Bersama <span class="text-pema-500">Kami</span>
                </h2>
                <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto"></div>
            </div>

            <div class="grid sm:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-pema-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fi fi-rs-briefcase text-pema-500 text-2xl"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 mb-2">Profesional</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Lingkungan kerja profesional yang mendukung pengembangan karir dan kompetensi.
                    </p>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-gold-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fi fi-rs-graduation-cap text-gold-500 text-2xl"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 mb-2">Berkembang</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Kesempatan untuk terus belajar dan berkembang bersama perusahaan.
                    </p>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-pema-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fi fi-rs-hand-holding-heart text-pema-500 text-2xl"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 mb-2">Berdampak</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Berkontribusi langsung dalam pembangunan dan kesejahteraan masyarakat Aceh.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
