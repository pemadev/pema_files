<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Panel Admin PT PEMA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-pema-800 via-pema-700 to-pema-900 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('logo-pema.webp') }}" alt="PT PEMA" class="h-14 mx-auto brightness-0 invert opacity-90">
                <p class="text-white/60 text-sm mt-3">Panel Admin</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-2xl shadow-black/20 p-8">
                <h1 class="text-2xl font-heading font-bold text-gray-900 text-center mb-2">Masuk</h1>
                <p class="text-gray-500 text-sm text-center mb-8">Masukkan email dan password admin</p>

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all @error('email') border-red-300 @enderror"
                            placeholder="Please enter your email">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="password" required autocomplete="off"
                                class="w-full px-4 py-2.5 pr-12 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all"
                                placeholder="••••••••">
                            <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pema-500 transition-colors p-1">
                                <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-pema-500 focus:ring-pema-500">
                            <span class="text-sm text-gray-600">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-2.5 bg-pema-500 hover:bg-pema-600 text-white font-medium rounded-xl transition-all duration-200 shadow-lg shadow-pema-500/25 hover:shadow-pema-500/40">
                        Masuk
                    </button>
                </form>
            </div>

            <p class="text-center text-white/40 text-xs mt-6">&copy; {{ date('Y') }} PT PEMA. Panel Admin.</p>
        </div>
    </div>
</body>
</html>
