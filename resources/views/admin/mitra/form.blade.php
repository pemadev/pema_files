@extends('admin.layouts.master')

@section('title', $partner->exists ? 'Edit Mitra Kerja' : 'Tambah Mitra Kerja')
@section('page_title', $partner->exists ? 'Edit Mitra Kerja' : 'Tambah Mitra Kerja')

@section('content')
<div class="max-w-2xl">
    <form method="POST"
          action="{{ $partner->exists ? route('admin.mitra.update', $partner) : route('admin.mitra.store') }}"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if($partner->exists)
            @method('PUT')
        @endif

        <!-- Basic Info Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-building text-green-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Informasi Mitra</h3>
            </div>
            <div class="p-5 space-y-5">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Perusahaan / Mitra <span class="text-red-400">*</span></label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $partner->name) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('name') border-red-300 @enderror"
                           placeholder="Masukkan nama perusahaan">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-1.5">Website</label>
                    <input type="url"
                           id="website"
                           name="website"
                           value="{{ old('website', $partner->website) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('website') border-red-300 @enderror"
                           placeholder="https://example.com">
                    @error('website')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                @php
                    $sortedPartners = isset($partners) ? $partners->sortBy('sort_order')->values()->map(fn($p) => ['id' => $p->id, 'name' => $p->name]) : collect();
                    $partnersJson = $sortedPartners->toJson();
                    $totalSlots = $sortedPartners->count() + 1;
                @endphp
                <div x-data="{ order: {{ old('sort_order', $partner->sort_order ?? 1) }}, partners: {{ $partnersJson }} }">
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1.5">Urutan</label>
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
                    <template x-if="partners.length > 0">
                        <div class="mt-2 text-xs text-gray-500 space-y-1">
                            <div x-show="order > 1" x-text="'Setelah: ' + partners[order - 2].name" class="text-pema-600 font-medium"></div>
                            <div x-show="order < partners.length + 1 && partners[order - 1]" x-text="'Sebelum: ' + partners[order - 1].name" class="text-amber-600 font-medium"></div>
                            <div x-show="order === 1" class="text-green-600 font-medium">Paling Awal</div>
                            <div x-show="order > partners.length" class="text-gray-400">Paling Akhir</div>
                        </div>
                    </template>
                    @error('sort_order')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Logo Card -->
        <div x-data="{ logoPreview: '' }" class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-picture text-blue-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Logo</h3>
            </div>
            <div class="p-5 space-y-4">
                @if($partner->exists && $partner->logo)
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-2">Logo Saat Ini:</p>
                        <img src="{{ Storage::url($partner->logo) }}"
                             alt="{{ $partner->name }}"
                             class="h-32 w-auto rounded-xl border border-gray-100 shadow-sm bg-white p-2">
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        @if($partner->exists) Ganti Logo @else Upload Logo @endif
                    </label>
                    <div class="relative">
                        <input type="file"
                               id="logo"
                               name="logo"
                               accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml"
                               @change="logoPreview = URL.createObjectURL($event.target.files[0])"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-pema-50 file:text-pema-600 hover:file:bg-pema-100 transition-all cursor-pointer @error('logo') border border-red-300 rounded-xl @enderror">
                    </div>
                    @error('logo')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, WebP, SVG. Maks: 2MB.</p>
                    <template x-if="logoPreview">
                        <div class="mt-3">
                            <p class="text-xs font-medium text-gray-500 mb-2">Preview:</p>
                            <img :src="logoPreview" alt="Preview logo"
                                 class="h-32 w-auto rounded-xl border border-gray-100 shadow-sm bg-white p-2">
                        </div>
                    </template>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 px-5 pt-4 pb-5 border-t border-gray-100">
                <a href="{{ route('admin.mitra.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    {{ $partner->exists ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
