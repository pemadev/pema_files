@extends('layouts.app')

@section('title', 'Hubungi Kami - PT PEMA')
@section('meta_description', 'Hubungi PT Pembangunan Aceh (PEMA) — Kirim pesan langsung melalui form kontak atau temukan lokasi kantor kami di Banda Aceh.')

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

        <!-- Map + Form Row -->
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Left Column: Google Maps -->
            <div class="animate-slide-in-left">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <iframe
                        src="https://maps.google.com/maps?ll=5.540777,95.313287&z=16&t=m&hl=en-US&gl=US&q=PT+PEMA+Banda+Aceh+Aceh&output=embed"
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

            <!-- Right Column: Contact Form -->
            <div class="animate-slide-in-right">
                <div class="bg-white rounded-2xl p-6 lg:p-8 border border-gray-100 shadow-sm">
                    <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">Kirim Pesan</h3>
                    <p class="text-gray-500 text-sm mb-6">
                        Silakan hubungi kami melalui saluran kontak di atas atau kirimkan pesan langsung melalui media sosial resmi PEMA.
                    </p>

                    <form action="{{ route('kontak.send') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    placeholder="Masukkan nama Anda"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 outline-none focus:ring-2 focus:ring-pema-500 focus:border-transparent transition-all duration-200"
                                >
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="Masukkan email Anda"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 outline-none focus:ring-2 focus:ring-pema-500 focus:border-transparent transition-all duration-200"
                                >
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1.5">Subjek</label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    placeholder="Masukkan subjek pesan"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 outline-none focus:ring-2 focus:ring-pema-500 focus:border-transparent transition-all duration-200"
                                >
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1.5">Pesan</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="4"
                                    placeholder="Tulis pesan Anda di sini..."
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 outline-none focus:ring-2 focus:ring-pema-500 focus:border-transparent transition-all duration-200 resize-none"
                                ></textarea>
                        </div>
                        <button
                            type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-pema-500 text-white font-medium rounded-xl hover:bg-pema-600 focus:ring-2 focus:ring-pema-500 focus:ring-offset-2 transition-all duration-200"
                        >
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
