@extends('admin.layouts.auth')

@section('title', 'Atur Ulang Password')
@section('icon', 'fi-rs-lock')
@section('heading', 'Buat Password Baru')
@section('subheading')
    Untuk akun <span class="font-medium text-gray-700">{{ $email }}</span>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-5"
          x-data="{
              show: false, password: '', confirmation: '', saving: false,
              get tooShort() { return this.password.length > 0 && this.password.length < 8 },
              get mismatch() { return this.confirmation.length > 0 && this.password !== this.confirmation },
          }"
          @submit="if (password.length < 8 || password !== confirmation) { $event.preventDefault(); return; } saving = true">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'" id="password" name="password" x-model="password" required autofocus
                       autocomplete="new-password" class="auth-input @error('password') is-invalid @enderror" style="padding-right:2.75rem"
                       placeholder="Minimal 8 karakter">
                <button type="button" @click="show = !show" tabindex="-1" :title="show ? 'Sembunyikan' : 'Tampilkan'"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600">
                    <i class="fi" :class="show ? 'fi-rs-eye-crossed' : 'fi-rs-eye'"></i>
                </button>
            </div>
            <p x-show="tooShort" x-cloak class="text-xs mt-1" style="color:#dc2626">Password minimal 8 karakter.</p>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Ulangi Password Baru</label>
            <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" x-model="confirmation" required
                   autocomplete="new-password" class="auth-input" placeholder="Ketik ulang password baru">
            <p x-show="mismatch" x-cloak class="text-xs mt-1" style="color:#dc2626">Konfirmasi password tidak cocok.</p>
        </div>

        <button type="submit" :disabled="saving"
                class="w-full py-2.5 px-4 bg-pema-500 hover:bg-pema-600 text-white font-medium rounded-xl shadow-sm transition-all inline-flex items-center justify-center gap-2"
                :style="saving ? 'opacity:.65;cursor:wait' : ''">
            <i class="fi fi-rs-check"></i>
            <span x-text="saving ? 'Menyimpan...' : 'Simpan Password Baru'"></span>
        </button>

        <a href="{{ route('admin.password.request') }}"
           class="block text-center text-sm font-medium text-gray-500 hover:text-pema-600 transition-colors">
            Tautan kedaluwarsa? Minta tautan baru
        </a>
    </form>
@endsection
