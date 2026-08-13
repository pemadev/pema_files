@extends('layouts.app')

@section('title', 'Hubungi Kami - PT PEMA')
@section('meta_description', 'Hubungi PT Pembangunan Aceh (PEMA) — Temukan lokasi kantor kami di Banda Aceh dan informasi kontak resmi.')

@section('content')
<!-- Page Header -->
<section class="relative pt-20 pb-16 lg:pb-20 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 -right-20 w-80 h-80 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="max-w-3xl">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">
                    Kontak
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                <span class="gradient-gold">Hubungi</span> Kami
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                Silakan hubungi PT Pembangunan Aceh (PEMA) melalui saluran komunikasi yang tersedia di bawah ini.
            </p>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Title Row -->
        <div class="animate-fade-in-up mb-10">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Informasi Kontak</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                Kantor <span class="text-pema-500">Pusat</span>
            </h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full"></div>
        </div>

        <!-- Map + Alamat Kantor Row -->
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">

            <!-- Left Column: Google Maps -->
            <div class="animate-slide-in-left">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <iframe
                        src="https://maps.google.com/maps?ll=5.556639418601494, 95.32456641020168&z=16&t=m&hl=en-US&gl=US&q=PT+PEMA+Banda+Aceh+Aceh&output=embed"
                        style="width: 100%; height: 500px;"
                        frameborder="0"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi Kantor PT PEMA"
                    >
                    </iframe>
                </div>
            </div>

           <!-- Right Column: Alamat Kantor -->
                <div class="animate-slide-in-right">
                    <div class="bg-gray rounded-2xl p-8 lg:p-10 border border-gray-100 shadow-sm h-full flex flex-col justify-center">
                    <h3 class="font-heading font-bold text-xl text-gray-900 uppercase tracking-wide mb-8">
                        Alamat Kantor
                    </h3>

        <div class="space-y-4">

    <!-- Alamat -->
    <div class="flex items-start gap-4">
        <div class="group w-11 h-11 rounded-xl bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center flex-shrink-0 transition-transform duration-300 hover:scale-110 hover:-rotate-3">
            <i class="fi fi-rs-marker text-orange-500 text-lg animate-pulse-slow"></i>
        </div>
        <div>
            <h4 class="text-xs font-semibold uppercase tracking-wide text-gold-500 mb-1.5">Alamat</h4>
            <p class="text-sm leading-relaxed text-black-600">
                Rumah Budaya, Jl. Tgk Moh. Daud Beureueh, Kec. Kuta Alam, Kota Banda Aceh 23121
            </p>
        </div>
    </div>

    <!-- Telepon -->
    <div class="flex items-start gap-4">
        <div class="group w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center flex-shrink-0 transition-transform duration-300 hover:scale-110 hover:rotate-3">
            <i class="fi fi-rs-phone-call text-emerald-500 text-lg animate-pulse-slow"></i>
        </div>
        <div>
            <h4 class="text-xs font-semibold uppercase tracking-wide text-gold-500 mb-1.5">Telepon</h4>
            <p class="text-sm text-black-600">0651-47414</p>
        </div>
    </div>

    <!-- Email -->
    <div class="flex items-start gap-4">
        <div class="group w-11 h-11 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center flex-shrink-0 transition-transform duration-300 hover:scale-110 hover:-rotate-3">
            <i class="fi fi-rs-envelope text-blue-500 text-lg animate-pulse-slow"></i>
        </div>
        <div>
            <h4 class="text-xs font-semibold uppercase tracking-wide text-gold-500 mb-1.5">Email</h4>
            <p class="text-sm text-black-600">contact@pema.co.id</p>
        </div>
    </div>

    <!-- Fax -->
    <div class="flex items-start gap-4">
        <div class="group w-11 h-11 rounded-xl bg-gradient-to-br from-purple-100 to-purple-50 flex items-center justify-center flex-shrink-0 transition-transform duration-300 hover:scale-110 hover:rotate-3">
            <i class="fi fi-rs-fax text-purple-500 text-lg animate-pulse-slow"></i>
        </div>
        <div>
            <h4 class="text-xs font-semibold uppercase tracking-wide text-gold-500 mb-1.5">Fax</h4>
            <p class="text-sm text-black-600">0651-47414</p>
        </div>
    </div>

</div>
</section>

@endsection