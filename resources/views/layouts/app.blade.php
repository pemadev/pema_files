<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <title>@yield('title', 'PT PEMA - PT Pembangunan Aceh')</title>
    <meta name="description" content="@yield('meta_description', 'PT Pembangunan Aceh (PEMA) - Badan Usaha Milik Daerah Aceh yang bergerak di bidang Migas, Agroindustri, dan Jasa dan Perdagangan untuk meningkatkan pembangunan dan perekonomian Aceh.')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', 'PT PEMA - PT Pembangunan Aceh')">
    <meta property="og:description" content="@yield('og_description', 'Badan Usaha Milik Daerah Aceh yang bergerak di bidang Migas, Agroindustri, dan Jasa dan Perdagangan.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('logo-pema.png') }}">
    <meta property="og:site_name" content="PT PEMA - PT Pembangunan Aceh">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'PT PEMA - PT Pembangunan Aceh')">
    <meta name="twitter:description" content="@yield('og_description', 'Badan Usaha Milik Daerah Aceh yang bergerak di bidang Migas, Agroindustri, dan Jasa dan Perdagangan.')">
    <meta name="twitter:image" content="{{ asset('logo-pema.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&amp;family=Plus+Jakarta+Sans:wght@500;600;700;800&amp;display=swap" rel="stylesheet">

    <!-- Flaticon CDN -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-straight/css/uicons-solid-straight.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/3.0.0/uicons-brands/css/uicons-brands.css">

    <!-- JSON-LD Structured Data -->
    @php
        $orgJson = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'PT Pembangunan Aceh (PEMA)',
            'url' => url('/'),
            'logo' => asset('logo-pema.png'),
            'description' => 'Badan Usaha Milik Daerah Aceh. Migas, Agroindustri, Jasa dan Perdagangan.',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+62-651-47414',
                'contactType' => 'customer service',
            ],
        ];
    @endphp
    <script type="application/ld+json">{{ json_encode($orgJson, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <!-- Google Analytics 4 -->
    @if(config('services.ga4_measurement_id') || env('GA4_MEASUREMENT_ID'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GA4_MEASUREMENT_ID') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ env('GA4_MEASUREMENT_ID') }}');
        </script>
    @endif
</head>
<body class="min-h-screen bg-white">

    <!-- Navigation -->
    <x-nav />

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <x-footer />

    @auth
        <div class="fixed bottom-6 right-6 z-50 group">
            <div class="absolute bottom-full right-0 mb-3 hidden group-hover:block">
                <div class="bg-gray-900 text-white text-xs font-medium px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap">
                    Ke Dashboard Admin
                    <div class="absolute top-full right-4 w-2 h-2 bg-gray-900 rotate-45 -mt-1"></div>
                </div>
            </div>
            <a href="{{ route('admin.dashboard') }}"
               class="w-14 h-14 bg-pema-500 hover:bg-pema-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </a>
        </div>
    @endauth

    @stack('scripts')
</body>
</html>
