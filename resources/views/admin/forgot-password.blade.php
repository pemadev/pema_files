<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Panel Admin PEMA</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .navy-bg {
            background: radial-gradient(circle at 30% 20%, #1e4d8f 0%, #123a70 35%, #0a1f42 75%, #050f24 100%);
        }
    </style>
</head>
<body class="navy-bg min-h-screen flex flex-col items-center justify-center px-4 py-12" x-data="forgotForm()">

    <!-- Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('logo-pema.webp') }}" alt="PT PEMA" class="h-20 brightness-0 invert mx-auto">
            </div>
        </svg>
        
    </div>

    {{-- Kartu --}}
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl px-4 py-8 sm:px-8">

        <h1 class="text-2xl font-bold text-gray-900 text-center">Lupa Password</h1>
        <p class="text-sm text-gray-500 text-center mt-2 mb-8">
            Masukkan email admin Anda, kami akan mengirimkan tautan untuk mengatur ulang password.
        </p>

        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-100 px-4 py-3 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

            <form method="POST" action="{{ route('admin.password.email') }}" @submit.prevent="submitForm($event)" novalidate>
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    x-model="email"
                    @blur="validateEmail()"
                    value="{{ old('email') }}"
                    placeholder="Please enter your email"
                    required
                    autofocus
                    class="w-full rounded-xl border px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 transition"
                    :class="error ? 'border-red-300 focus:ring-red-200' : 'border-gray-200 focus:ring-blue-200 focus:border-blue-400'"
                >
                <p x-show="error" x-text="error" class="mt-1.5 text-xs text-red-500"></p>
                @error('email')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                :disabled="submitting"
                class="w-full bg-blue-700 hover:bg-blue-800 disabled:opacity-60 text-white font-semibold text-base rounded-xl py-3.5 transition shadow-lg shadow-blue-900/20">
                <span x-show="!submitting">Reset</span>
                <span x-show="submitting">Mengirim...</span>
            </button>

            <a href="{{ route('admin.login') }}" class="block text-center text-sm font-medium text-gray-500 hover:text-gray-800 mt-6 transition">
                &larr; Kembali ke halaman masuk
            </a>
        </form>
    </div>

    <p class="text-white/40 text-sm mt-8 text-center">
        &copy; {{ date('Y') }} PT PEMA. Panel Admin.
    </p>

    <script>
        function forgotForm() {
            return {
                email: '{{ old('email') }}',
                error: null,
                submitting: false,

                validateEmail() {
                    const email = this.email.trim();
                    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!email) {
                        this.error = 'Email wajib diisi.';
                    } else if (!pattern.test(email)) {
                        this.error = 'Format email tidak valid.';
                    } else {
                        this.error = null;
                    }
                    return !this.error;
                },

                submitForm(event) {
                    if (!this.validateEmail()) return;
                    this.submitting = true;
                    event.target.submit();
                }
            }
        }
    </script>
</body>
</html>