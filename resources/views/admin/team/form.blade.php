@extends('admin.layouts.master')

@section('title', $team->exists ? 'Edit Anggota Tim' : 'Tambah Anggota Tim')
@section('page_title', $team->exists ? 'Edit Anggota Tim' : 'Tambah Anggota Tim')

@section('content')
<div class="max-w-2xl">
    <form method="POST"
          action="{{ $team->exists ? route('admin.team.update', $team) : route('admin.team.store') }}"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if($team->exists)
            @method('PUT')
        @endif

        <!-- Basic Info Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-users text-pema-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Informasi Anggota</h3>
            </div>
            <div class="p-5 space-y-5">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $team->name) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('name') border-red-300 @enderror"
                           placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan <span class="text-red-400">*</span></label>
                    <input type="text"
                           id="position"
                           name="position"
                           value="{{ old('position', $team->position) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('position') border-red-300 @enderror"
                           placeholder="Mis: Direktur Utama">
                    @error('position')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biodata -->
                <div>
                    <label for="biodata" class="block text-sm font-medium text-gray-700 mb-1.5">Biodata<span class="text-red-400">*</span></label>
                    <textarea id="biodata"
                            name="biodata"
                            rows="6"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all resize-none @error('biodata') border-red-300 @enderror"
                            placeholder="Masukkan biodata atau profil singkat anggota direksi/komisaris...">{{ old('biodata', $team->biodata) }}</textarea>
                    @error('biodata')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                        <p class="mt-1 text-xs text-gray-400">
                            Contoh: Riwayat pendidikan, pengalaman kerja, serta jabatan yang pernah diemban.
                        </p>
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-400">*</span></label>
                    <select id="category"
                            name="category"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('category') border-red-300 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="direksi" {{ old('category', $team->category) == 'direksi' ? 'selected' : '' }}>Direksi</option>
                        <option value="komisaris" {{ old('category', $team->category) == 'komisaris' ? 'selected' : '' }}>Komisaris</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                @php
                    $sortedMembers = isset($members) ? $members->sortBy('sort_order')->values()->map(fn($m) => ['id' => $m->id, 'name' => $m->name]) : collect();
                    $membersJson = $sortedMembers->toJson();
                    $totalSlots = $sortedMembers->count() + 1;
                @endphp
                <div x-data="{ order: {{ old('sort_order', $team->sort_order ?? 1) }}, members: {{ $membersJson }} }">
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1.5">Urutan Tampil</label>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="order = Math.max(1, order - 1)"
                                class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-pema-500 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                        </button>
                        <input type="number" id="sort_order" name="sort_order" x-model="order"
                               min="1" max="{{ $totalSlots }}"
                               class="w-20 px-3 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm text-center transition-all @error('sort_order') border-red-300 @enderror"
                               placeholder="1">
                        <button type="button" @click="order = Math.min({{ $totalSlots }}, order + 1)"
                                class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-pema-500 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                        <span class="text-xs text-gray-400">dari {{ $totalSlots }}</span>
                    </div>
                    <template x-if="members.length > 0">
                        <div class="mt-2 text-xs text-gray-500 space-y-1">
                            <div x-show="order > 1" x-text="'Setelah: ' + members[order - 2].name" class="text-pema-600 font-medium"></div>
                            <div x-show="order < members.length + 1 && members[order - 1]" x-text="'Sebelum: ' + members[order - 1].name" class="text-amber-600 font-medium"></div>
                            <div x-show="order === 1" class="text-green-600 font-medium">Paling Awal</div>
                            <div x-show="order > members.length" class="text-gray-400">Paling Akhir</div>
                        </div>
                    </template>
                    @error('sort_order')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto <span class="text-gray-400 font-normal">(opsional)</span></label>
                    @if($team->exists && $team->photo)
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                            <img src="{{ Storage::url($team->photo) }}"
                                 alt="{{ $team->name }}"
                                 class="w-24 h-24 rounded-xl object-cover border border-gray-100 shadow-sm">
                        </div>
                    @endif
                    <input type="file"
                           id="photo"
                           name="photo"
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-pema-50 file:text-pema-600 hover:file:bg-pema-100 transition-all cursor-pointer @error('photo') border border-red-300 rounded-xl @enderror">
                    @error('photo')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, WebP. Maks: 2MB.</p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.team.index') }}"
                       class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                        {{ $team->exists ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
