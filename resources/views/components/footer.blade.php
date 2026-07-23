<footer class="bg-pema-800 text-white">
    @php
        $footerSettings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
    @endphp
    <!-- Main Footer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- Company Info -->
            <div class="lg:col-span-1">
                <a href="{{ route('beranda') }}" class="inline-block mb-5">
                    <img src="{{ asset('logo-pema.webp') }}" alt="PT PEMA" class="h-14 w-auto brightness-0 invert opacity-90 hover:opacity-100 transition-opacity">
                </a>
                <p class="text-gray-300 text-sm leading-relaxed mb-6">
                    Badan Usaha Milik Daerah Aceh yang bergerak di bidang Migas, Agroindustri, serta Jasa & Perdagangan untuk meningkatkan pembangunan dan perekonomian Aceh.
                </p>
                <!-- Social Media -->
                <div class="flex items-center gap-3">
                    <a href="{{ $footerSettings['instagram'] ?? '#' }}" target="_blank" class="w-10 h-10 bg-white/10 hover:bg-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 group">
                        <i class="fi fi-brands-instagram text-white/80 group-hover:text-white text-lg"></i>
                    </a>
                    <a href="https://www.tiktok.com/@ptpema" target="_blank"
                    class="w-10 h-10 bg-white/10 hover:bg-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 group">
                    <svg class="w-5 h-5 text-white/80 group-hover:text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16.6 5.82c-.9-.88-1.44-2.06-1.5-3.32V2h-3.4v13.4a2.59 2.59 0 1 1-1.83-2.47V9.4a5.99 5.99 0 0 0-1.17-.12A6.02 6.02 0 1 0 14.7 15.4V9.68a7.87 7.87 0 0 0 4.6 1.47V7.75c-1.01 0-2-.31-2.83-.89-.28-.2-.55-.42-.87-.85z"/>
                    </svg>
                    </a>
                    <a href="{{ $footerSettings['youtube'] ?? '#' }}" target="_blank" class="w-10 h-10 bg-white/10 hover:bg-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 group">
                        <i class="fi fi-brands-youtube text-white/80 group-hover:text-white text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-heading font-semibold text-white text-sm uppercase tracking-wider mb-5">Link Umum</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('beranda') }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors flex items-center gap-2"><span class="w-1 h-1 bg-gold-500 rounded-full"></span>Beranda</a></li>
                    <li><a href="{{ route('berita.index') }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors flex items-center gap-2"><span class="w-1 h-1 bg-gold-500 rounded-full"></span>Artikel</a></li>
                    <li><a href="{{ route('berita.index') }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors flex items-center gap-2"><span class="w-1 h-1 bg-gold-500 rounded-full"></span>Berita</a></li>
                    <li><a href="{{ route('pengumuman.index') }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors flex items-center gap-2"><span class="w-1 h-1 bg-gold-500 rounded-full"></span>Pengumuman</a></li>
                    <li><a href="{{ route('karir') }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors flex items-center gap-2"><span class="w-1 h-1 bg-gold-500 rounded-full"></span>Karir</a></li>
                </ul>
            </div>

            <!-- Business Links -->
<div>
    <h4 class="font-heading font-semibold text-white text-sm uppercase tracking-wider mb-5">Bidang Usaha</h4>
    <ul class="space-y-3">
        <li><a href="{{ route('bisnis.category', 'migas') }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors flex items-center gap-2"><span class="w-1 h-1 bg-gold-500 rounded-full"></span>Migas</a></li>
        <li><a href="{{ route('bisnis.category', 'agroindustri') }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors flex items-center gap-2"><span class="w-1 h-1 bg-gold-500 rounded-full"></span>Agroindustri</a></li>
        <li><a href="{{ route('bisnis.category', 'jasa') }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors flex items-center gap-2"><span class="w-1 h-1 bg-gold-500 rounded-full"></span>Jasa & Perdagangan</a></li>
    </ul>


    <div class="mt-8">
        <h4 class="font-heading font-semibold text-white text-sm uppercase tracking-wider mb-4">Untuk Mendapatkan Informasi PPID Lebih Lanjut</h4>
        <div class="flex items-center gap-3">

           {{-- App Store --}}
<a href="https://apps.apple.com/id/app/harmoni/id6754546755?l=id" target="_blank"
   class="w-10 h-10 bg-white/10 hover:bg-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 group">
    <svg class="w-5 h-5 text-white/80 group-hover:text-white" viewBox="0 0 24 24" fill="currentColor">
        <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
    </svg>
</a>

            {{-- Play Store --}}
<a href="https://play.google.com/store/apps/details?id=com.pema.attendance_app_2&hl=id" target="_blank"
   class="w-10 h-10 bg-white/10 hover:bg-gold-500 rounded-lg flex items-center justify-center transition-all duration-300 group">
    <svg class="w-5 h-5 text-white/80 group-hover:text-white" viewBox="0 0 24 24" fill="currentColor">
        <path d="M3.18 23.76c.3.17.65.19.97.07l.1-.06 11.05-6.37-2.38-2.38-9.74 8.74zM.75 1.93C.44 2.3.25 2.83.25 3.49v17.02c0 .66.19 1.19.5 1.56l.08.08 9.54-9.54v-.22L.83 1.85l-.08.08zM20.12 9.84l-2.55-1.47-2.69 2.69 2.69 2.68 2.57-1.48c.73-.42.73-1.1-.02-1.42zM3.18.24L13.92 6.6l-2.38 2.38L2.25.31c.28-.18.63-.2.93-.07z"/>
    </svg>
</a>

        </div>
    </div>
</div>


            <!-- Contact Info -->
            <div>
                <h4 class="font-heading font-semibold text-white text-sm uppercase tracking-wider mb-5">Kontak</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <i class="fi fi-rs-marker text-gold-400 mt-1 text-lg"></i>
                        <span class="text-gray-300 text-sm leading-relaxed">
                            {{ $footerSettings['alamat'] ?? 'Rumah Budaya, Jl. Tgk Moh. Daud Beureueh, Kec. Kuta Alam, Kota Banda Aceh 23121' }}
                        </span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fi fi-rs-phone-call text-gold-400 text-lg"></i>
                        <a href="tel:{{ $footerSettings['telepon'] ?? '+6265147414' }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors">{{ $footerSettings['telepon'] ?? '0651-47414' }}</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fi fi-rs-envelope text-gold-400 text-lg"></i>
                        <a href="mailto:{{ $footerSettings['email'] ?? 'contact@pema.co.id' }}" class="text-gray-300 hover:text-gold-400 text-sm transition-colors">{{ $footerSettings['email'] ?? 'contact@pema.co.id' }}</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fi fi-rs-fax text-gold-400 text-lg"></i>
                        <span class="text-gray-300 text-sm">{{ $footerSettings['fax'] ?? '0651-47414' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} PT Pembangunan Aceh (PEMA). All rights reserved.
                </p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('privacy') }}" class="text-gray-400 hover:text-gold-400 text-sm transition-colors">Kebijakan Privasi</a>
                    <a href="{{ route('policy') }}" class="text-gray-400 hover:text-gold-400 text-sm transition-colors">Privacy Policy</a>
                    <a href="{{ route('terms') }}" class="text-gray-400 hover:text-gold-400 text-sm transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </div>
</footer>
