@extends('admin.layouts.master')

@section('title', 'Edit Profil')
@section('page_title', 'Edit Profil')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Informasi Akun -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-user text-pema-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Informasi Akun</h3>
            </div>
            <div class="p-5 space-y-5">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('name') border-red-300 @enderror"
                           placeholder="Nama lengkap">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('email') border-red-300 @enderror"
                           placeholder="admin@pema.co.id">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Ubah Password -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-gold-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-lock text-gold-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Ubah Password</h3>
            </div>
            <div class="p-5 space-y-5">
                <p class="text-xs text-gray-400">Kosongkan jika tidak ingin mengganti password.</p>

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Saat Ini</label>
                    <input type="password"
                           id="current_password"
                           name="current_password"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('current_password') border-red-300 @enderror"
                           placeholder="Masukkan password saat ini">
                    @error('current_password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('password') border-red-300 @enderror"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all"
                           placeholder="Ulangi password baru">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 px-5 pt-4 pb-5 border-t border-gray-100">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    <i class="fi fi-rs-save text-sm"></i>
                    Simpan Profil
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
