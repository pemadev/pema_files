{{-- Layout halaman tamu panel admin (lupa password, reset password). Gaya sama dengan halaman login. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title') - Panel Admin PT PEMA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .auth-input { width: 100%; padding: .7rem 1rem; border: 1px solid #e5e7eb; border-radius: .75rem; font-size: .875rem; outline: none; transition: border-color .15s, box-shadow .15s; }
        .auth-input:focus { border-color: #0A6AC9; box-shadow: 0 0 0 3px rgba(10,106,201,.15); }
        .auth-input.is-invalid { border-color: #fca5a5; background: #fef2f2; }
        .auth-alert { display: flex; gap: .6rem; align-items: flex-start; padding: .75rem 1rem; border-radius: .75rem; font-size: .875rem; line-height: 1.45; margin-bottom: 1.25rem; }
        .auth-alert--success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .auth-alert--error { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-pema-800 via-pema-700 to-pema-900 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">
            <div class="text-center mb-4">
                <img src="{{ asset('logo-pema.webp') }}" alt="PT PEMA" class="h-20 brightness-0 invert mx-auto">
            </div>

            <div class="bg-white rounded-2xl shadow-2xl shadow-black/20 p-8">
                <div class="mx-auto mb-4 w-12 h-12 rounded-2xl bg-pema-50 flex items-center justify-center">
                    <i class="fi @yield('icon', 'fi-rs-lock') text-pema-500 text-xl"></i>
                </div>
                <h1 class="text-2xl font-heading font-bold text-gray-900 text-center">@yield('heading')</h1>
                <p class="text-gray-500 text-sm text-center mt-2 mb-6">@yield('subheading')</p>

                @if (session('status'))
                    <div class="auth-alert auth-alert--success" role="status">
                        <i class="fi fi-rs-check-circle" style="margin-top:2px"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="auth-alert auth-alert--error" role="alert">
                        <i class="fi fi-rs-exclamation" style="margin-top:2px"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @yield('content')
            </div>

            <p class="text-center text-white/50 text-sm mt-6">&copy; {{ date('Y') }} PT PEMA. Panel Admin.</p>
        </div>
    </div>
</body>
</html>
