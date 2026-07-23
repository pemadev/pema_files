<nav x-data="{ mobileOpen: false, openDropdown: null, openSubDropdown: null }"
     class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-300 shadow-sm"
     @click.outside="openDropdown = null; openSubDropdown = null">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <a href="{{ route('beranda') }}" class="flex items-center flex-shrink-0">
                <img src="{{ asset('logo-pema.webp') }}" alt="PT PEMA" class="h-16 w-auto">
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1">
                <!-- Beranda -->
                <a href="{{ route('beranda') }}"
                   class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-pema-500 rounded-lg hover:bg-pema-50 transition-all duration-200 {{ request()->routeIs('beranda') ? 'text-pema-500 bg-pema-50' : '' }}">
                   Beranda
                </a>

                <!-- Profil - Dropdown -->
                <div class="relative"
                     @mouseenter="openDropdown = 'profil'"
                     @mouseleave="openDropdown = null">
                    <button class="flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 hover:text-pema-500 rounded-lg hover:bg-pema-50 transition-all duration-200 {{ request()->routeIs('profil') ? 'text-pema-500 bg-pema-50' : '' }}">
                        Profil
                        <svg class="w-3.5 h-3.5 mt-0.5 transition-transform duration-200" :class="{'rotate-180': openDropdown === 'profil' }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openDropdown === 'profil'"
                         x-cloak
                         @mouseenter="openDropdown = 'profil'"
                         @mouseleave="openDropdown = null"
                          class="absolute top-full left-0 w-52 bg-white rounded-xl shadow-xl shadow-black/5 border border-gray-100 py-2"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <a href="{{ route('profil') }}#visi-misi" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors" section id="visi-misi" class="scroll-mt-24">Visi dan Misi</a>
                        <a href="{{ route('profil') }}#sambutan" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Sambutan Dirut</a>
                        <a href="{{ route('profil') }}#sejarah" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Sejarah PT PEMA</a>
                        <a href="{{ route('profil') }}#stakeholder" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Stakeholder</a>
                        <a href="{{ route('profil') }}#direksi" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Direksi & Komisaris</a>
                    </div>
                </div>

                <!-- Bisnis - Dropdown -->
                <div class="relative"
                     @mouseenter="openDropdown = 'bisnis'"
                     @mouseleave="openDropdown = null">
                    <button class="flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 hover:text-pema-500 rounded-lg hover:bg-pema-50 transition-all duration-200 {{ request()->routeIs('bisnis') ? 'text-pema-500 bg-pema-50' : '' }}">
                        Bisnis
                        <svg class="w-3.5 h-3.5 mt-0.5 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'bisnis' }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="openDropdown === 'bisnis'"
                         x-cloak
                         @mouseenter="openDropdown = 'bisnis'"
                         @mouseleave="openDropdown = null"
                         class="absolute top-full left-0 w-48 bg-white rounded-xl shadow-xl shadow-black/5 border border-gray-100 py-2"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <a href="{{ route('bisnis.category', 'migas') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Migas</a>
                        <a href="{{ route('bisnis.category', 'agroindustri') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Agroindustri</a>
                        <a href="{{ route('bisnis.category', 'jasa') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Jasa & Perdagangan</a>
                    </div>
                </div>

                <!-- Produk -->
                @php
                    $produkLink = \App\Models\Setting::getValue('produk_link', 'https://ipro.pema.co.id');
                @endphp
                <a href="{{ $produkLink }}" target="_blank"
                   class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-pema-500 rounded-lg hover:bg-pema-50 transition-all duration-200">
                    Produk
                </a>

                <!-- Media - Dropdown -->
                <div class="relative"
                     @mouseenter="openDropdown = 'media'"
                     @mouseleave="openDropdown = null">
                    <button class="flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 hover:text-pema-500 rounded-lg hover:bg-pema-50 transition-all duration-200">
                        Media
                        <svg class="w-3.5 h-3.5 mt-0.5 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'media' }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openDropdown === 'media'"
                         x-cloak
                         @mouseenter="openDropdown = 'media'"
                         @mouseleave="openDropdown = null"
                          class="absolute top-full left-0 w-48 bg-white rounded-xl shadow-xl shadow-black/5 border border-gray-100 py-2"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <a href="{{ route('berita.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Berita</a>
                        <a href="{{ route('pengumuman.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Pengumuman</a>
                        <a href="{{ route('galeri') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Galeri PEMA</a>
                        <a href="{{ route('laporan') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Laporan</a>
                        <a href="{{ route('agenda') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Agenda</a>
                    </div>
                </div>

                <!-- Karir -->
                <a href="{{ route('karir') }}"
                   class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-pema-500 rounded-lg hover:bg-pema-50 transition-all duration-200">
                   Karir
                </a>

                <!-- Kerjasama - Dropdown -->
                <div class="relative"
                     @mouseenter="openDropdown = 'kerjasama'"
                     @mouseleave="openDropdown = null">
                    <button class="flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 hover:text-pema-500 rounded-lg hover:bg-pema-50 transition-all duration-200">
                        Kerjasama
                        <svg class="w-3.5 h-3.5 mt-0.5 transition-transform duration-200" :class="{ 'rotate-180': openDropdown === 'kerjasama' }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openDropdown === 'kerjasama'"
                         x-cloak
                         @mouseenter="openDropdown = 'kerjasama'"
                         @mouseleave="openDropdown = null"
                          class="absolute top-full left-0 w-44 bg-white rounded-xl shadow-xl shadow-black/5 border border-gray-100 py-2"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <a href="{{ route('kerjasama') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Mitra</a>
                        <a href="https://ivds.pema.co.id" target="_blank" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-pema-500 hover:bg-pema-50 transition-colors">Vendor</a>
                    </div>
                </div>

                <!-- PPID -->
                @php
                    $PPIDLink = \App\Models\Setting::getValue('ppid_link', 'https://eppid.pema.co.id/');
                @endphp
                <a href="{{ $PPIDLink }}" target="_blank"
                   class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-pema-500 rounded-lg hover:bg-pema-50 transition-all duration-200">
                    PPID
                </a>

                <!-- Kontak -->
                <a href="{{ route('kontak') }}"
                   class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-pema-500 rounded-lg hover:bg-pema-50 transition-all duration-200">
                   Kontak
                </a>
            </div>

            <!-- Mobile menu button -->
            <button @click="mobileOpen = !mobileOpen"
                    class="lg:hidden p-2 rounded-lg text-gray-600 hover:text-pema-500 hover:bg-pema-50 transition-all">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-show="mobileOpen"
         x-cloak
         class="lg:hidden border-t border-gray-100 bg-white"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-1 max-h-[80vh] overflow-y-auto">
            <a href="{{ route('beranda') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">Beranda</a>

            <!-- Mobile: Profil -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">
                    Profil
                    <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="ml-4 space-y-1">
                    <a href="{{ route('profil') }}#visi-misi" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Visi dan Misi</a>
                    <a href="{{ route('profil') }}#sambutan" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Sambutan Dirut</a>
                    <a href="{{ route('profil') }}#sejarah" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Sejarah PT PEMA</a>
                    <a href="{{ route('profil') }}#stakeholder" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Stakeholder</a>
                    <a href="{{ route('profil') }}#team" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Direksi & Komisaris</a>
                </div>
            </div>

            <!-- Mobile: Bisnis -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">
                    Bisnis
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('bisnis.category', 'migas') }}" class="block px-4 py-2.5 text-sm text-gray-600 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">Migas</a>
                    <a href="{{ route('bisnis.category', 'agroindustri') }}" class="block px-4 py-2.5 text-sm text-gray-600 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">Agroindustri</a>
                    <a href="{{ route('bisnis.category', 'jasa') }}" class="block px-4 py-2.5 text-sm text-gray-600 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">Jasa & Perdagangan</a>
                </div>
            </div>

            <a href="{{ $produkLink }}" target="_blank" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">Produk</a>

            <!-- Mobile: Media -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">
                    Media
                    <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="ml-4 space-y-1">
                    <a href="{{ route('berita.index') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Berita</a>
                    <a href="{{ route('pengumuman.index') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Pengumuman</a>
                    <a href="{{ route('galeri') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Galeri PEMA</a>
                    <a href="{{ route('laporan') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Laporan</a>
                    <a href="{{ route('agenda') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Agenda</a>
                </div>
            </div>

            <a href="{{ route('karir') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">Karir</a>

            <!-- Mobile: Kerjasama -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">
                    Kerjasama
                    <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="ml-4 space-y-1">
                    <a href="{{ route('kerjasama') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Mitra</a>
                    <a href="https://ivds.ptpema.co.id" target="_blank" class="block px-4 py-2 text-sm text-gray-500 hover:text-pema-500 rounded-lg transition-colors">Vendor</a>
                </div>
            </div>

            <a href="{{ $PPIDLink }}" target="_blank" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">PPID</a>

            <a href="{{ route('kontak') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-colors">Kontak</a>
        </div>
    </div>
</nav>
