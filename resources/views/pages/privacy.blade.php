@extends('layouts.app')

@section('title', 'Kebijakan Privasi - PT PEMA')
@section('meta_description', 'Kebijakan Privasi PT Pembangunan Aceh (PEMA) mengenai pengumpulan, penggunaan, dan perlindungan data pribadi.')

@section('content')
<section class="relative pt-20 pb-16 lg:pb-20 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="max-w-3xl">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">Legal</span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">Kebijakan <span class="gradient-gold">Privasi</span></h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">PT Pembangunan Aceh (PEMA)</p>
        </div>
    </div>
</section>

<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-gray max-w-none">
            <p class="text-gray-600 leading-relaxed">Terakhir diperbarui: 2026</p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">1. Pendahuluan</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                PT Pembangunan Aceh (PEMA) berkomitmen untuk melindungi privasi pengguna website ini. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengungkapkan, dan melindungi informasi pribadi Anda sesuai dengan peraturan perundang-undangan yang berlaku di Indonesia.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">2. Informasi yang Kami Kumpulkan</h2>
            <p class="text-gray-600 leading-relaxed mb-4">Kami dapat mengumpulkan informasi berikut:</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Informasi identitas pribadi (nama, alamat email, nomor telepon)</li>
                <li>Informasi demografis (preferensi, minat)</li>
                <li>Data penggunaan website (cookies, alamat IP, jenis browser, halaman yang dikunjungi)</li>
                <li>Informasi lain yang relevan dengan survei dan/atau penawaran</li>
            </ul>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">3. Penggunaan Informasi</h2>
            <p class="text-gray-600 leading-relaxed mb-4">Informasi yang kami kumpulkan digunakan untuk:</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Menyediakan dan memelihara layanan website</li>
                <li>Meningkatkan pengalaman pengguna</li>
                <li>Menghubungi Anda terkait pertanyaan atau permintaan</li>
                <li>Mengirimkan informasi terkait perusahaan dan kegiatan PEMA</li>
                <li>Menganalisis tren dan perilaku pengguna untuk pengembangan website</li>
            </ul>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">4. Perlindungan Data</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Kami berkomitmen untuk menjaga keamanan informasi pribadi Anda. Kami menerapkan langkah-langkah pengamanan fisik, elektronik, dan prosedural yang sesuai untuk melindungi data pribadi dari akses tidak sah, perubahan, pengungkapan, atau perusakan.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">5. Hak Anda</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Anda berhak untuk mengakses, memperbaiki, atau menghapus data pribadi yang kami miliki. Anda juga dapat menarik persetujuan penggunaan data kapan saja dengan menghubungi kami melalui kontak yang tersedia di website ini.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">6. Perubahan Kebijakan</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Kebijakan Privasi ini dapat diperbarui dari waktu ke waktu. Perubahan akan diumumkan melalui halaman ini dengan memperbarui tanggal "Terakhir diperbarui" di bagian atas.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">7. Kontak</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Jika Anda memiliki pertanyaan mengenai Kebijakan Privasi ini, silakan hubungi kami melalui:
            </p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Email: contact@pema.co.id</li>
                <li>Telepon: 0651-47414</li>
                <li>Alamat: Rumah Budaya, Jl. Tgk Moh. Daud Beureueh, Kec. Kuta Alam, Kota Banda Aceh 23121</li>
            </ul>
        </div>
    </div>
</section>
@endsection
