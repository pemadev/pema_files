@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan - PT PEMA')
@section('meta_description', 'Syarat dan Ketentuan penggunaan website PT Pembangunan Aceh (PEMA).')

@section('content')
<section class="relative pt-20 pb-16 lg:pb-20 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-20 w-80 h-80 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="max-w-3xl">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">Legal</span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">Syarat dan <span class="gradient-gold">Ketentuan</span></h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">PT Pembangunan Aceh (PEMA)</p>
        </div>
    </div>
</section>

<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-gray max-w-none">
            <p class="text-gray-600 leading-relaxed">Terakhir diperbarui: 2026</p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">1. Penerimaan Syarat</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Dengan mengakses dan menggunakan website PT Pembangunan Aceh (PEMA), Anda menyatakan telah membaca, memahami, dan menyetujui untuk terikat oleh Syarat dan Ketentuan ini. Jika Anda tidak setuju dengan sebagian atau seluruh syarat, mohon untuk tidak menggunakan website ini.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">2. Penggunaan Website</h2>
            <p class="text-gray-600 leading-relaxed mb-4">Anda setuju untuk menggunakan website ini hanya untuk tujuan yang sah dan tidak melanggar hak pihak ketiga. Dilarang:</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Menggunakan website untuk kegiatan ilegal atau terlarang</li>
                <li>Mendistribusikan virus atau kode berbahaya lainnya</li>
                <li>Mengganggu atau membebani infrastruktur website secara berlebihan</li>
                <li>Mengakses area terbatas tanpa otorisasi</li>
            </ul>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">3. Kekayaan Intelektual</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Seluruh konten website ini, termasuk namun tidak terbatas pada teks, gambar, logo, grafik, audio, video, dan perangkat lunak, adalah milik PT PEMA atau pemberi lisensinya dan dilindungi oleh undang-undang hak cipta dan kekayaan intelektual yang berlaku. Dilarang mereproduksi, mendistribusikan, memodifikasi, atau menampilkan konten tanpa izin tertulis dari PT PEMA.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">4. Informasi dan Akurasi</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Kami berusaha menyajikan informasi yang akurat dan terkini di website ini. Namun, kami tidak memberikan jaminan mengenai keakuratan, kelengkapan, atau keandalan informasi. Penggunaan informasi dari website ini sepenuhnya merupakan risiko Anda sendiri.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">5. Tautan ke Pihak Ketiga</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Website ini mungkin berisi tautan ke website pihak ketiga yang tidak dikelola oleh PT PEMA. Kami tidak bertanggung jawab atas konten, kebijakan privasi, atau praktik website pihak ketiga.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">6. Pembatasan Tanggung Jawab</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                PT PEMA tidak bertanggung jawab atas kerugian langsung, tidak langsung, insidental, atau konsekuensial yang timbul dari penggunaan atau ketidakmampuan menggunakan website ini.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">7. Perubahan Syarat</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                PT PEMA berhak mengubah Syarat dan Ketentuan ini sewaktu-waktu. Perubahan akan diumumkan melalui halaman ini. Penggunaan website setelah perubahan dianggap sebagai penerimaan terhadap syarat yang baru.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">8. Hukum yang Berlaku</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Syarat dan Ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Negara Kesatuan Republik Indonesia.
            </p>

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">9. Kontak</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Untuk pertanyaan mengenai Syarat dan Ketentuan ini, silakan hubungi:
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
