@extends('admin.layouts.master')

@section('title', 'Tambah Pengguna')
@section('page_title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
        @csrf

        <div x-data="{ show: false, show2: false, pw: '' }" class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-user-add text-pema-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Informasi Pengguna</h3>
            </div>
            <div class="p-5 space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('name') border-red-300 @enderror"
                           placeholder="Nama lengkap">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('email') border-red-300 @enderror"
                           placeholder="admin@pema.co.id">
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" x-model="pw"
                                   class="w-full px-4 py-2.5 pr-10 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('password') border-red-300 @enderror"
                                   placeholder="Minimal 8 karakter">
                            <button type="button" @click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pema-500 transition-colors">
                                <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        <button type="button" @click="pw = Array.from({length:16},()=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*'[Math.floor(Math.random()*72)]).join(''); $nextTick(() => { $refs.pwModal.classList.remove('hidden') })"
                                class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-600 hover:bg-gray-100 hover:text-pema-500 transition-all whitespace-nowrap flex-shrink-0 font-medium">
                            Generate
                        </button>
                    </div>
                    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <div class="relative">
                        <input :type="show2 ? 'text' : 'password'" id="password_confirmation" name="password_confirmation"
                               class="w-full px-4 py-2.5 pr-10 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all"
                               placeholder="Ulangi password">
                        <button type="button" @click="show2 = !show2"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pema-500 transition-colors">
                            <svg x-show="!show2" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show2" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password Generator Modal -->
            <div x-ref="pwModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40" @click.self="$el.classList.add('hidden')">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 max-w-md w-full mx-4">
                <h3 class="font-heading font-semibold text-gray-900 text-sm mb-1">Password Generated</h3>
                <p class="text-xs text-gray-400 mb-4">Password telah digenerate. Salin dan gunakan sesuai kebutuhan.</p>
                <div class="flex items-center gap-2 bg-gray-50 rounded-xl border border-gray-200 px-4 py-3 mb-4">
                    <code class="flex-1 text-sm font-mono text-gray-800 break-all" x-text="pw"></code>
                    <button type="button" @click="navigator.clipboard.writeText(pw); $el.textContent = 'Tersalin!'" class="text-xs font-medium text-pema-500 hover:text-pema-600 whitespace-nowrap">
                        Salin
                    </button>
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="$refs.pwModal.classList.add('hidden')" class="px-4 py-2 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
            </div>
            <div class="flex items-center justify-end gap-3 px-5 pt-4 pb-5 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    <i class="fi fi-rs-save text-sm"></i>
                    Simpan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
