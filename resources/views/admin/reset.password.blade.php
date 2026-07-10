<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - Panel Admin PEMA</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .navy-bg {
            background: radial-gradient(circle at 30% 20%, #1e4d8f 0%, #123a70 35%, #0a1f42 75%, #050f24 100%);
        }
    </style>
</head>
<body class="navy-bg min-h-screen flex flex-col items-center justify-center px-4 py-12" x-data="resetForm()">

         <!-- Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('logo-pema.webp') }}" alt="PT PEMA" class="h-20 brightness-0 invert mx-auto">
            </div>
        </svg>
        <div class="text-white leading-tight">
            <div class="font-extrabold text-2xl tracking-wide">PEMA</div>
            <div class="text-[11px] font-semibold tracking-wider">PEMBANGUNAN ACEH</div>
            <div class="text-[10px] text-white/70">Perseroda</div>
        </div>
    </div>

    {{-- Kartu --}}
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl px-8 py-10 sm:px-10">

        <h1 class="text-2xl font-bold text-gray-900 text-center">Atur Ulang Password</h1>
        <p class="text-sm text-gray-500 text-center mt-2 mb-8">
            Buat password baru untuk akun <span class="font-medium text-gray-700">{{ $email }}</span>.
        </p>

        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}" @submit.prevent="submitForm($event)" novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                <div class="relative">
                    <input
                        :type="show ? 'text' : 'password'"
                        name="password"
                        x-model="password"
                        @input="validate()"
                        placeholder="Minimal 8 karakter"
                        required
                        class="w-full rounded-xl border px-4 py-3 pr-11 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 transition"
                        :class="error ? 'border-red-300 focus:ring-red-200' : 'border-gray-200 focus:ring-blue-200 focus:border-blue-400'"
                    >
                    <button type="button" @click="show = !show" tabindex="-1"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                <input
                    :type="show ? 'text' : 'password'"
                    name="password_confirmation"
                    x-model="confirmation"
                    @input="validate()"
                    placeholder="Ulangi password baru"
                    required
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition"
                >
            </div>
            <p x-show="error" x-text="error" class="mb-4 text-xs text-red-500"></p>

            <button
                type="submit"
                :disabled="submitting"
                class="w-full bg-blue-700 hover:bg-blue-800 disabled:opacity-60 text-white font-semibold text-base rounded-xl py-3.5 transition shadow-lg shadow-blue-900/20"
            >
                <span x-show="!submitting">Simpan Password Baru</span>
                <span x-show="submitting">Menyimpan...</span>
            </button>
        </form>
    </div>

    <p class="text-white/40 text-sm mt-8 text-center">
        &copy; {{ date('Y') }} PT PEMA. Panel Admin.
    </p>

    <script>
        function resetForm() {
            return {
                password: '',
                confirmation: '',
                show: false,
                error: null,
                submitting: false,

                validate() {
                    if (!this.password || this.password.length < 8) {
                        this.error = 'Password minimal 8 karakter.';
                    } else if (this.confirmation && this.password !== this.confirmation) {
                        this.error = 'Konfirmasi password tidak cocok.';
                    } else {
                        this.error = null;
                    }
                    return !this.error;
                },

                submitForm(event) {
                    if (!this.validate()) return;
                    this.submitting = true;
                    event.target.submit();
                }
            }
        }
    </script>
</body>
</html>