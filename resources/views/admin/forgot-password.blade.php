@extends('admin.layouts.auth')

@section('title', 'Lupa Password')
@section('icon', 'fi-rs-key')
@section('heading', 'Lupa Password')
@section('subheading', 'Masukkan email akun admin Anda. Kami akan mengirimkan tautan untuk membuat password baru.')

@section('content')
    <form method="POST" action="{{ route('admin.password.email') }}" class="space-y-5"
          x-data="{ sending: false }" @submit="sending = true">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                   class="auth-input @error('email') is-invalid @enderror" placeholder="nama@pema.co.id">
        </div>

        <button type="submit" :disabled="sending"
                class="w-full py-2.5 px-4 bg-pema-500 hover:bg-pema-600 text-white font-medium rounded-xl shadow-sm transition-all inline-flex items-center justify-center gap-2"
                :style="sending ? 'opacity:.65;cursor:wait' : ''">
            <i class="fi fi-rs-paper-plane"></i>
            <span x-text="sending ? 'Mengirim...' : 'Kirim Tautan Reset'"></span>
        </button>

        <a href="{{ route('admin.login') }}"
           class="block text-center text-sm font-medium text-gray-500 hover:text-pema-600 transition-colors">
            &larr; Kembali ke halaman masuk
        </a>
    </form>
@endsection
