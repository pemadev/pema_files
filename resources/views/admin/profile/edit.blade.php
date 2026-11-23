@extends('admin.layouts.master')

@section('title', 'Edit Profil')
@section('page_title', 'Edit Profil')

@push('styles')
<style>
    .avatar-picker { position: relative; width: 96px; height: 96px; border-radius: 9999px; cursor: pointer; flex-shrink: 0; box-shadow: 0 0 0 4px #fff, 0 0 0 5px #e5e7eb; overflow: hidden; }
    .avatar-picker__img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-picker__initial { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 600; }
    .avatar-picker__overlay { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(15,23,42,.45); color: #fff; font-size: 22px; opacity: 0; transition: opacity .15s; }
    .avatar-picker:hover .avatar-picker__overlay { opacity: 1; }
</style>
@endpush

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Foto Profil -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm"
             x-data="{
                preview: @js($user->avatar_url),
                hapus: false,
                pilih(e) {
                    const f = e.target.files[0];
                    if (!f) return;
                    if (f.size > 2 * 1024 * 1024) { alert('Ukuran foto maksimal 2MB.'); e.target.value = ''; return; }
                    this.preview = URL.createObjectURL(f);
                    this.hapus = false;
                },
                buang() { this.preview = null; this.hapus = true; this.$refs.file.value = ''; }
             }">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-camera text-pema-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Foto Profil</h3>
            </div>
            <div class="p-5">
                <div class="flex flex-wrap items-center gap-5">
                    {{-- Pratinjau: klik foto untuk memilih file --}}
                    <label for="avatar" class="avatar-picker" title="Ganti foto">
                        <template x-if="preview">
                            <img :src="preview" alt="Foto profil" class="avatar-picker__img" x-on:error="preview = null">
                        </template>
                        <template x-if="!preview">
                            <span class="avatar-picker__initial bg-pema-100 text-pema-600">{{ $user->initial }}</span>
                        </template>
                        <span class="avatar-picker__overlay"><i class="fi fi-rs-camera"></i></span>
                    </label>

                    <div class="space-y-2">
                        <div class="flex flex-wrap gap-2">
                            <label for="avatar"
                                   class="cursor-pointer px-4 py-2 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-colors inline-flex items-center gap-2">
                                <i class="fi fi-rs-upload text-sm"></i>
                                <span x-text="preview ? 'Ganti Foto' : 'Unggah Foto'"></span>
                            </label>
                            <button type="button" x-show="preview" @click="buang()"
                                    class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors inline-flex items-center gap-2">
                                <i class="fi fi-rs-trash text-sm"></i>
                                Hapus
                            </button>
                        </div>
                        <p class="text-xs text-gray-400">JPG, PNG, atau WebP. Maksimal 2MB. Disarankan foto persegi.</p>
                        <p class="text-xs text-amber-600" x-show="hapus" x-cloak>Foto akan dihapus setelah Anda klik <b>Simpan Profil</b>.</p>
                    </div>
                </div>

                <input type="file" id="avatar" name="avatar" x-ref="file" accept="image/jpeg,image/png,image/webp" class="hidden" @change="pilih($event)">
                <input type="hidden" name="remove_avatar" :value="hapus ? 1 : 0">
                @error('avatar')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

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
