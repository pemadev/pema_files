<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Panel Admin PT PEMA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.1.12/dist/trix.css">
    <style>
        trix-editor.trix-content { min-height: 180px; max-height: 400px; overflow-y: auto; border-radius: 0.75rem; border-color: oklch(0.928 0.006 264.531); }
        trix-editor.trix-content:focus { border-color: #0A6AC9; box-shadow: 0 0 0 3px rgba(10,106,201,0.1); }
        trix-toolbar .trix-button-row { gap: 2px; }
        trix-toolbar .trix-button { border-radius: 6px !important; height: 2em !important; }
        .trix-button--icon { width: 2em !important; }
    </style>
    @stack('styles')
</head>
<body x-data="{ sidebarOpen: true, mobileSidebar: false }"
      x-init="sidebarOpen = window.innerWidth >= 1024"
      class="font-sans antialiased bg-gray-50 min-h-screen">

    <!-- Sidebar Overlay (mobile) -->
    <div x-show="mobileSidebar" x-cloak
         @@click="mobileSidebar = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"></div>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen || mobileSidebar"
           :class="mobileSidebar ? 'translate-x-0' : (sidebarOpen ? 'translate-x-0' : '-translate-x-full')"
           class="fixed top-0 left-0 z-50 h-full w-64 bg-white border-r border-gray-100 shadow-sm transition-transform duration-300 lg:translate-x-0 overflow-y-auto flex flex-col"
           x-cloak>

        <!-- Logo & Close -->
        <div class="h-16 flex items-center justify-between px-5 border-b border-gray-100 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo-pema.webp') }}" alt="PT PEMA" class="h-9 w-auto">
            </a>
            <button @@click="mobileSidebar = false" class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-pema-500 hover:bg-pema-50 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="p-3 space-y-1 flex-1 overflow-y-auto">
            <x-admin.sidebar-item icon="fi fi-rs-home" href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" label="Dashboard" />

            <!-- Manajemen Sistem -->
            <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 pt-5 pb-2">Manajemen Sistem</div>
            <x-admin.sidebar-item icon="fi fi-rs-users" href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')" label="Pengguna" />

            <!-- Profil & Organisasi -->
            <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 pt-5 pb-2">Profil & Organisasi</div>
            <x-admin.sidebar-item icon="fi fi-rs-building" href="{{ route('admin.profil.index') }}" :active="request()->routeIs('admin.profil.*')" label="Profil Perusahaan" />
            <x-admin.sidebar-item icon="fi fi-rs-users" href="{{ route('admin.team.index') }}" :active="request()->routeIs('admin.team.*')" label="Direksi & Komisaris" />
            <x-admin.sidebar-item icon="fi fi-rs-handshake" href="{{ route('admin.mitra.index') }}" :active="request()->routeIs('admin.mitra.*')" label="Mitra Kerja" />

            <!-- Konten -->
            <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 pt-5 pb-2">Konten</div>
            <x-admin.sidebar-item icon="fi fi-rs-newspaper" href="{{ route('admin.berita.index') }}" :active="request()->routeIs('admin.berita.*')" label="Berita" />
            <x-admin.sidebar-item icon="fi fi-rs-megaphone" href="{{ route('admin.pengumuman.index') }}" :active="request()->routeIs('admin.pengumuman.*')" label="Pengumuman" />

            <!-- Media & Portofolio -->
            <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 pt-5 pb-2">Media & Portofolio</div>
            <x-admin.sidebar-item icon="fi fi-rs-images" href="{{ route('admin.galeri.index') }}" :active="request()->routeIs('admin.galeri.*')" label="Galeri Foto" />
            <x-admin.sidebar-item icon="fi fi-rs-sliders-v" href="{{ route('admin.banner.index') }}" :active="request()->routeIs('admin.banner.*')" label="Banner Halaman Depan" />
            <x-admin.sidebar-item icon="fi fi-rs-briefcase" href="{{ route('admin.bisnis.index') }}" :active="request()->routeIs('admin.bisnis.*')" label="Bidang Bisnis" />

            <!-- Informasi -->
            <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 pt-5 pb-2">Informasi</div>
            <x-admin.sidebar-item icon="fi fi-rs-document" href="{{ route('admin.laporan.index') }}" :active="request()->routeIs('admin.laporan.*')" label="Laporan" />
            <x-admin.sidebar-item icon="fi fi-rs-calendar" href="{{ route('admin.agenda.index') }}" :active="request()->routeIs('admin.agenda.*')" label="Agenda" />

            <!-- Komunikasi -->
            <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 pt-5 pb-2">Komunikasi</div>
            <x-admin.sidebar-item icon="fi fi-rs-envelope" href="{{ route('admin.enquiry.index') }}" :active="request()->routeIs('admin.enquiry.*')" label="Pesan Kontak" :badge="App\Models\Enquiry::where('is_read', false)->count()" />

            <!-- Settings -->
            <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 pt-5 pb-2">Sistem</div>
            <x-admin.sidebar-item icon="fi fi-rs-settings" href="{{ route('admin.settings.index') }}" :active="request()->routeIs('admin.settings.*')" label="Pengaturan" />
        </nav>

        <!-- Bottom Profile Card -->
        <a href="{{ route('admin.profile.edit') }}" class="border-t border-gray-100 p-3 flex-shrink-0 block hover:opacity-80 transition-opacity">
            <div class="bg-gradient-to-br from-pema-50 to-pema-100 rounded-xl p-3 flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 bg-pema-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fi fi-rs-user text-white text-sm"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-gray-900 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-gray-600 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </a>
    </aside>

    <!-- Main Content -->
    <div :class="sidebarOpen ? 'lg:pl-64' : ''" class="transition-all duration-300">
        <!-- Top Bar -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-gray-100">
            <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                <div class="flex items-center gap-3">
                    <button @@click="sidebarOpen = !sidebarOpen" class="hidden lg:flex p-2 rounded-lg text-gray-500 hover:text-pema-500 hover:bg-pema-50 transition-all">
                        <i class="fi fi-rs-bars-staggered"></i>
                    </button>
                    <button @@click="mobileSidebar = true" class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-pema-500 hover:bg-pema-50 transition-all">
                        <i class="fi fi-rs-bars-staggered"></i>
                    </button>
                    <h2 class="text-sm font-medium text-gray-700 hidden sm:block">@yield('page_title', 'Dashboard')</h2>
                </div>

                <div x-data="{}" class="relative">
                    <button @click="$refs.profileDropdown.classList.toggle('hidden')" @click.outside="$refs.profileDropdown.classList.add('hidden')" class="flex items-center gap-2 px-3 py-1.5 rounded-xl text-sm transition-all duration-200 hover:bg-gray-50">
                        <div class="w-8 h-8 bg-pema-100 rounded-full flex items-center justify-center">
                            <i class="fi fi-rs-user text-pema-500 text-sm"></i>
                        </div>
                        <span class="hidden sm:block text-gray-700 font-medium">{{ Auth::user()->email }}</span>
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-ref="profileDropdown" class="hidden absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-xl shadow-black/5 border border-gray-100 py-2 z-50"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="px-4 py-3 border-b border-gray-50">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fi fi-rs-user text-base text-gray-400"></i>
                            Edit Profil
                        </a>
                        <a href="{{ route('beranda') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fi fi-rs-globe text-base text-gray-400"></i>
                            Lihat Website
                        </a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="pt-1 border-t border-gray-50 mt-1">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fi fi-rs-sign-out-alt text-base"></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4 lg:p-6">
            <!-- Toast Notification -->
            <div x-data="{ show: false, type: 'success', title: '', message: '' }"
                 x-init="
                     @if(session('success'))
                         type = 'success'; title = 'Berhasil'; message = '{{ session('success') }}'; show = true; setTimeout(() => show = false, 5000);
                     @elseif(session('error'))
                         type = 'error'; title = 'Gagal'; message = '{{ session('error') }}'; show = true; setTimeout(() => show = false, 5000);
                     @endif
                  "
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-8"
                 @click="show = false"
                 class="fixed top-20 right-4 lg:right-6 z-[60] cursor-pointer max-w-lg"
                 x-cloak>
                <div :class="type === 'success' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'"
                     class="rounded-2xl p-4 border shadow-lg flex items-start gap-3">
                    <i :class="type === 'success' ? 'fi fi-rs-check-circle text-green-500' : 'fi fi-rs-exclamation text-red-500'"
                       class="text-lg flex-shrink-0 mt-0.5"></i>
                    <div>
                        <h4 :class="type === 'success' ? 'text-green-900' : 'text-red-900'"
                            class="font-semibold text-sm" x-text="title"></h4>
                        <p :class="type === 'success' ? 'text-green-700' : 'text-red-700'"
                           class="text-sm mt-0.5" x-text="message"></p>
                    </div>
                </div>
            </div>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="px-4 lg:px-6 py-4 border-t border-gray-100">
            <p class="text-xs text-gray-400 text-center">&copy; {{ date('Y') }} PT PEMA. Panel Admin v1.0</p>
        </footer>
    </div>

    <script type="text/javascript" src="https://unpkg.com/trix@2.1.12/dist/trix.umd.min.js"></script>
    <script>
        // Auto-scroll sidebar to active item
        document.addEventListener('DOMContentLoaded', function() {
            const activeItem = document.querySelector('aside nav .bg-pema-50');
            if (activeItem) {
                setTimeout(() => {
                    activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
