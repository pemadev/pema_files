@extends('layouts.app')

@section('title', 'Privacy Policy - PT PEMA')
@section('meta_description', 'Kebijakan Privasi Harmoni - HR & Monitoring Informasi PT Pembangunan Aceh (PEMA) mengenai pengumpulan, penggunaan, dan perlindungan data pribadi.')

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
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">Privacy<span class="gradient-gold">Policy</span></h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">Harmoni &ndash; HR &amp; Monitoring Informasi | PT Pembangunan Aceh (PEMA)</p>
        </div>
    </div>
</section>

<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-gray max-w-none">

            <p class="text-gray-600 leading-relaxed mb-1">Terakhir diperbarui: Oktober 28, 2025</p>
            <p class="text-gray-600 leading-relaxed mb-6">Privacy Policy &ndash; Harmoni | HR &amp; Monitoring Informasi</p>

            <p class="text-gray-600 leading-relaxed mb-1"><strong>Effective Date:</strong> 28/10/2025</p>
            <p class="text-gray-600 leading-relaxed mb-6"><strong>Last Updated:</strong> 25/11/2025</p>

            <p class="text-gray-600 leading-relaxed mb-4">
                Harmoni (&ldquo;Aplikasi&rdquo;) menghormati privasi pengguna (&ldquo;Anda&rdquo;) dan berkomitmen melindungi seluruh data pribadi yang diberikan melalui layanan aplikasi, termasuk fitur internal perusahaan (HR/Absensi) dan layanan publik (PPID).
            </p>
            <p class="text-gray-600 leading-relaxed mb-4">
                Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi data Anda.
            </p>

            <hr class="my-10 border-gray-200">

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">1. Informasi yang Kami Kumpulkan</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Aplikasi menyediakan dua kategori layanan: Layanan HR Internal dan Layanan Publik PPID. Jenis data yang dikumpulkan berbeda sesuai layanan yang digunakan.
            </p>

            <hr class="my-10 border-gray-200">

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">1.1. Informasi untuk Layanan HR Internal</h3>

            <p class="font-semibold text-gray-800 mt-6 mb-2">a. Informasi Akun Karyawan</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Nama lengkap</li>
                <li>Email</li>
                <li>Nomor telepon (opsional)</li>
                <li>ID Karyawan / NIK Internal</li>
                <li>Jabatan &amp; divisi (jika disediakan perusahaan)</li>
            </ul>

            <p class="font-semibold text-gray-800 mt-6 mb-2">b. Informasi Lokasi</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Lokasi GPS akurat saat check-in/check-out</li>
                <li>Tidak digunakan untuk pelacakan atau iklan</li>
            </ul>

            <p class="font-semibold text-gray-800 mt-6 mb-2">c. Data Aktivitas</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Riwayat presensi</li>
                <li>Riwayat cuti dan izin</li>
                <li>Waktu login dan logout</li>
            </ul>

            <p class="font-semibold text-gray-800 mt-6 mb-2">d. Data Teknis</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Jenis perangkat</li>
                <li>Versi OS</li>
                <li>Crash log</li>
            </ul>

            <p class="font-semibold text-gray-800 mt-6 mb-2">e. Data Wajah (Face Data) untuk Verifikasi Presensi</p>
            <p class="text-gray-600 leading-relaxed mb-4">
                Data wajah (face embedding dan foto registrasi) disimpan hanya selama karyawan masih aktif bekerja dan menggunakan fitur presensi. Data ini diperlukan karena sistem presensi berbasis pencocokan wajah membutuhkan data referensi untuk memverifikasi identitas pengguna setiap kali melakukan check-in/check-out.
            </p>
            <p class="text-gray-600 leading-relaxed mb-4">
                Kami tidak menyimpan data wajah tanpa batas waktu (<em>not stored indefinitely</em>).
            </p>
            <p class="text-gray-600 leading-relaxed mb-2">Data wajah akan dihapus secara permanen ketika:</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>karyawan resign,</li>
                <li>akun karyawan dinonaktifkan, atau</li>
                <li>karyawan mengajukan permintaan penghapusan data wajah melalui admin HR.</li>
            </ul>
            <p class="text-gray-600 leading-relaxed mb-4">
                Foto wajah yang diambil saat presensi tidak pernah disimpan. Foto tersebut digunakan satu kali untuk proses pencocokan lokal, kemudian langsung dihapus.
            </p>
            <p class="text-gray-600 leading-relaxed mb-2">Aplikasi mengumpulkan data wajah hanya pada proses registrasi wajah, berupa:</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Foto wajah pada saat registrasi</li>
                <li>Data embedding wajah (non-biometric facial feature vector) yang dihasilkan Google ML Kit</li>
                <li>Landmark wajah non-biometrik</li>
            </ul>
            <p class="text-gray-600 leading-relaxed mb-2">Kami tidak mengumpulkan:</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Apple Face ID template</li>
                <li>Depth data</li>
                <li>Geometri wajah dari perangkat</li>
                <li>Foto absen harian (foto saat presensi tidak disimpan, hanya diproses untuk pencocokan)</li>
            </ul>

            <hr class="my-10 border-gray-200">

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">1.2 Informasi untuk Layanan Publik PPID</h3>
            <p class="text-gray-600 leading-relaxed mb-4">
                PPID adalah layanan publik untuk permohonan informasi sesuai UU Keterbukaan Informasi Publik.
            </p>
            <p class="text-gray-600 leading-relaxed mb-4">Data yang dikumpulkan:</p>

            <p class="font-semibold text-gray-800 mt-6 mb-2">a. Registrasi Pengguna Publik</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Nama lengkap</li>
                <li>Email</li>
                <li>Password</li>
            </ul>

            <p class="font-semibold text-gray-800 mt-6 mb-2">b. Data Profil Lanjutan</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Nomor KTP</li>
                <li>Nomor telepon</li>
                <li>Kategori pemohon (perorangan, kelompok, badan hukum, dll.)</li>
                <li>Alamat lengkap: Kelurahan/Desa, Kecamatan, Kabupaten/Kota, Provinsi, Kode Pos</li>
                <li>Dokumen foto/identitas (PDF)</li>
                <li>Surat Pengantar dari Instansi (PDF)</li>
            </ul>
            <p class="text-gray-600 leading-relaxed mb-4">
                Seluruh file PDF disimpan pada server internal perusahaan dan tidak dibagikan ke pihak eksternal.
            </p>

            <p class="font-semibold text-gray-800 mt-6 mb-2">c. Formulir Permohonan Informasi Publik</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Detail permohonan</li>
                <li>Alasan permohonan</li>
                <li>Dokumen pendukung (jika ada)</li>
            </ul>

            <p class="font-semibold text-gray-800 mt-6 mb-2">d. Formulir Keberatan</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Alasan keberatan</li>
                <li>Dokumen pendukung</li>
            </ul>

            <p class="font-semibold text-gray-800 mt-6 mb-2">e. Data Pengiriman Jawaban</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Metode pengiriman (ambil langsung, pos, kurir, email)</li>
                <li>Format jawaban (hardcopy/softcopy)</li>
            </ul>
            <p class="text-gray-600 leading-relaxed mb-4">
                PPID tidak menggunakan face recognition, biometrik, atau face embedding.
            </p>

            <hr class="my-10 border-gray-200">

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">2. Bagaimana Kami Menggunakan Informasi Anda</h2>

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">2.1 Untuk Layanan HR Internal</h3>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Verifikasi identitas karyawan saat presensi</li>
                <li>Verifikasi lokasi presensi</li>
                <li>Pengelolaan data presensi, cuti, izin, dan laporan HR</li>
                <li>Meningkatkan keamanan sistem</li>
                <li>Keperluan audit internal</li>
            </ul>

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">2.2 Untuk Layanan PPID</h3>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Memverifikasi identitas pemohon informasi</li>
                <li>Memproses permohonan informasi publik</li>
                <li>Memproses keberatan</li>
                <li>Mengirimkan jawaban permohonan</li>
                <li>Keperluan pelaporan PPID sesuai UU No. 14 Tahun 2008</li>
                <li>Peningkatan kualitas layanan publik</li>
            </ul>

            <hr class="my-10 border-gray-200">

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">3. Berbagi Data dengan Pihak Ketiga</h2>
            <p class="text-gray-600 leading-relaxed mb-4">Kami hanya membagikan data dalam kondisi berikut:</p>

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">3.1 HR Internal</h3>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Dengan perusahaan Anda sebagai pengelola data kepegawaian</li>
                <li>Dengan penyedia layanan server/hosting yang terikat kewajiban kerahasiaan</li>
            </ul>

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">3.2 PPID</h3>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Tidak ada data PPID yang dibagikan kepada pihak eksternal</li>
                <li>Data hanya dapat diakses oleh petugas internal dengan role admin_ppid</li>
                <li>Akses dilakukan melalui sistem internal perusahaan (intranet)</li>
            </ul>

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">3.3 Legal</h3>
            <p class="text-gray-600 leading-relaxed mb-4">Jika diwajibkan oleh peraturan perundang-undangan.</p>

            <hr class="my-10 border-gray-200">

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">4. Keamanan Data</h2>
            <p class="text-gray-600 leading-relaxed mb-4">Kami menerapkan langkah-langkah berikut:</p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Enkripsi data wajah dan data sensitif lainnya</li>
                <li>Pembatasan akses berbasis role (RBAC)</li>
                <li>Akses PPID hanya oleh admin internal perusahaan</li>
                <li>Penyimpanan file dokumen pada server aman</li>
                <li>Pemantauan dan audit keamanan berkala</li>
            </ul>

            <hr class="my-10 border-gray-200">

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">5. Hak Pengguna</h2>

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">5.1 Pengguna HR</h3>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Mengakses dan memperbarui informasi pribadi</li>
                <li>Meminta penghapusan data wajah</li>
                <li>Mengelola izin lokasi &amp; kamera</li>
                <li>Menghapus akun melalui admin HR</li>
            </ul>

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">5.2 Pengguna PPID</h3>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Mengakses dan memperbarui data profil</li>
                <li>Melihat riwayat permohonan</li>
                <li>Menghapus akun dan dokumen melalui admin PPID</li>
                <li>Mengajukan keberatan</li>
            </ul>

            <hr class="my-10 border-gray-200">

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">6. Penyimpanan dan Retensi Data</h2>

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">6.1 HR Internal</h3>
            <p class="text-gray-600 leading-relaxed mb-4">
                Data wajah (face embedding dan foto registrasi) disimpan untuk tujuan verifikasi presensi selama karyawan masih aktif bekerja.
            </p>
            <p class="text-gray-600 leading-relaxed mb-2">
                Untuk memenuhi standar privasi, data wajah tidak disimpan tanpa batas waktu. Retensi data mengikuti ketentuan berikut:
            </p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Data wajah disimpan selama masa aktif karyawan, dan</li>
                <li>Dihapus secara permanen dalam waktu maksimal 30 hari setelah: karyawan resign, akun dinonaktifkan, atau karyawan meminta penghapusan data wajah kepada admin HR.</li>
            </ul>
            <p class="text-gray-600 leading-relaxed mb-4">
                Periode retensi tambahan selama 30 hari diperlukan untuk memastikan proses administrasi HR selesai dan untuk mencegah masalah verifikasi presensi yang tertunda.
            </p>
            <p class="text-gray-600 leading-relaxed mb-4">
                Foto wajah saat presensi tidak pernah disimpan. Foto tersebut hanya digunakan sekali untuk pencocokan dan langsung dihapus.
            </p>

            <h3 class="font-heading font-semibold text-xl text-gray-800 mt-8 mb-3">6.2 PPID</h3>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Data permohonan dan dokumen disimpan sesuai ketentuan UU KIP</li>
                <li>Retensi minimum mengikuti peraturan internal perusahaan</li>
                <li>Dihapus permanen jika pengguna meminta penghapusan akun</li>
                <li>Dokumen PDF tidak disimpan lebih lama dari yang diperlukan untuk proses permohonan</li>
            </ul>

            <hr class="my-10 border-gray-200">

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">7. Perubahan Kebijakan Privasi</h2>
            <p class="text-gray-600 leading-relaxed mb-4">Kami dapat memperbarui kebijakan ini dari waktu ke waktu.</p>
            <p class="text-gray-600 leading-relaxed mb-4">Perubahan akan diumumkan melalui halaman resmi ini.</p>

            <hr class="my-10 border-gray-200">

            <h2 class="font-heading font-bold text-2xl text-gray-900 mt-10 mb-4">8. Kontak Kami</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Jika Anda memiliki pertanyaan mengenai kebijakan privasi ini:
            </p>
            <ul class="list-disc pl-6 text-gray-600 space-y-2 mb-4">
                <li>Email: <a href="mailto:it@ptpema.com" class="text-pema-700 hover:underline">it@ptpema.com</a></li>
            </ul>

        </div>
    </div>
</section>
@endsection