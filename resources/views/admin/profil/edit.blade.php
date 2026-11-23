@extends('admin.layouts.master')

@php
    $typeLabels = [
        'sambutan'   => 'Sambutan',
        'sejarah'    => 'Sejarah',
        'visi_misi'  => 'Visi & Misi',
        'stakeholder' => 'Stakeholder',
    ];
    $typeIcons = [
        'sambutan'   => 'fi fi-rs-hand-wave',
        'sejarah'    => 'fi fi-rs-timeline',
        'visi_misi'  => 'fi fi-rs-bullseye',
        'stakeholder' => 'fi fi-rs-users',
    ];
    $label = $typeLabels[$type] ?? ucfirst($type);
    $icon = $typeIcons[$type] ?? 'fi fi-rs-file';

    $fieldLabels = [
        'sambutan'   => ['title' => 'Nama Direktur',  'content' => 'Jabatan',                'additional' => 'Kata Sambutan'],
        'sejarah'    => ['title' => 'Judul',           'content' => 'Konten Sejarah',         'additional' => 'Informasi Tambahan'],
        'visi_misi'  => ['title' => 'Visi',            'content' => 'Misi',                   'additional' => 'Informasi Tambahan'],
        'stakeholder' => ['title' => 'Judul',          'content' => 'Konten Stakeholder',     'additional' => 'Informasi Tambahan'],
    ];
    $fl = $fieldLabels[$type] ?? ['title' => 'Judul', 'content' => 'Konten', 'additional' => 'Informasi Tambahan'];
@endphp

@section('title', 'Edit ' . $label)
@section('page_title', 'Edit ' . $label)

@push('styles')
<style>
    .modern-field { position: relative; display: flex; align-items: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; transition: border-color .15s, box-shadow .15s, background-color .15s; }
    .modern-field:hover { border-color: #cbd5e1; }
    .modern-field:focus-within { background: #fff; border-color: #0A6AC9; box-shadow: 0 0 0 4px rgba(10,106,201,.12); }
    .modern-field__icon { position: absolute; left: 16px; display: flex; color: #94a3b8; font-size: 16px; pointer-events: none; transition: color .15s; }
    .modern-field:focus-within .modern-field__icon { color: #0A6AC9; }
    .modern-field__input { width: 100%; height: 48px; padding: 0 16px 0 46px; border: 0 !important; background: transparent; border-radius: 14px; font-size: 15px; color: #0f172a; outline: none !important; box-shadow: none !important; }
    .modern-field__input::placeholder { color: #94a3b8; }
    .modern-field.is-invalid { border-color: #fca5a5; background: #fef2f2; }
    .modern-field.is-invalid:focus-within { box-shadow: 0 0 0 4px rgba(239,68,68,.12); }
</style>
@endpush

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.profil.update', $type) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Header Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center gap-4 mb-1">
                <div class="w-12 h-12 rounded-xl bg-pema-50 flex items-center justify-center">
                    <i class="{{ $icon }} text-pema-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-gray-900">{{ $label }}</h3>
                    <p class="text-sm text-gray-500">Kelola konten {{ strtolower($label) }} perusahaan</p>
                </div>
            </div>
        </div>

        <!-- Title -->
        <div x-data="{ 
                preview: false, 
                previewAdditional: false, 
                titleHtml: '{{ addslashes(old('title', $profile->title)) }}',
                contentHtml: '{{ addslashes(old('content', $profile->content)) }}', 
                additionalHtml: '{{ addslashes(old('additional_info', $profile->additional_info)) }}' 
             }"
             class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-5">
            
            {{-- Title --}}
            <div>
                @if($type === 'visi_misi')
                    {{-- Visi uses Trix editor --}}
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="title" class="block text-sm font-medium text-gray-700">{{ $fl['title'] }} <span class="text-red-500">*</span></label>
                        <button type="button" @click="preview = !preview"
                                class="text-xs font-medium text-pema-500 hover:text-pema-600 transition-colors inline-flex items-center gap-1">
                            <i class="fi" :class="preview ? 'fi-rs-edit' : 'fi-rs-eye'"></i>
                            <span x-text="preview ? 'Edit' : 'Preview'"></span>
                        </button>
                    </div>
                    <input type="hidden" id="title" name="title" value="{{ old('title', $profile->title) }}">
                    <trix-editor input="title" class="trix-content" placeholder="Masukkan visi perusahaan..." x-show="!preview"
                                 @trix-change="titleHtml = $event.target.value"></trix-editor>
                    <div x-show="preview" x-cloak
                         class="p-4 rounded-xl border border-gray-200 bg-gray-50 min-h-[120px] text-sm text-gray-700 leading-relaxed"
                         x-html="titleHtml">
                    </div>
                @elseif($type === 'sambutan')
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $fl['title'] }}</label>
                    <div class="modern-field @error('title') is-invalid @enderror">
                        <i class="fi fi-rs-user modern-field__icon"></i>
                        <input type="text" id="title" name="title" value="{{ old('title', $profile->title) }}"
                               class="modern-field__input" placeholder="Contoh: Faisal Ilyas S.E, M.M" autocomplete="off">
                    </div>
                @else
                    {{-- Other types use regular input --}}
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $fl['title'] }}</label>
                    <input type="text" id="title" name="title"
                           value="{{ old('title', $profile->title) }}"
                           class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('title') border-red-300 @enderror"
                           placeholder="Masukkan judul konten">
                @endif
                @error('title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            @if($type === 'sambutan')
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $fl['content'] }}</label>
                <div class="modern-field @error('content') is-invalid @enderror">
                    <i class="fi fi-rs-briefcase modern-field__icon"></i>
                    {{-- Data lama dari Trix bisa berisi tag HTML, jadi diambil teksnya saja --}}
                    <input type="text" id="content" name="content" maxlength="255"
                           value="{{ trim(html_entity_decode(strip_tags(str_replace(['<br>', '<br/>', '<br />'], ' ', (string) old('content', $profile->content))))) }}"
                           class="modern-field__input" placeholder="Contoh: Direktur Utama PT PEMA" autocomplete="off">
                </div>
                <p class="mt-1.5 text-xs text-gray-400">Ditampilkan di bawah nama direktur pada halaman Profil.</p>
                @error('content')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            @else
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="content" class="block text-sm font-medium text-gray-700">{{ $fl['content'] }}</label>
                    <button type="button" @click="preview = !preview"
                            class="text-xs font-medium text-pema-500 hover:text-pema-600 transition-colors inline-flex items-center gap-1">
                        <i class="fi" :class="preview ? 'fi-rs-edit' : 'fi-rs-eye'"></i>
                        <span x-text="preview ? 'Edit' : 'Preview'"></span>
                    </button>
                </div>
                <input type="hidden" id="content" name="content" value="{{ old('content', $profile->content) }}">
                <trix-editor input="content" class="trix-content" placeholder="Masukkan konten..." x-show="!preview"
                             @trix-change="contentHtml = $event.target.value"></trix-editor>
                <div x-show="preview" x-cloak
                     class="p-4 rounded-xl border border-gray-200 bg-gray-50 min-h-[180px] text-sm text-gray-700 leading-relaxed"
                     x-html="contentHtml">
                </div>
                @error('content')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            @endif

            {{-- Sejarah, Visi Misi & Stakeholder tidak memakai Informasi Tambahan & Gambar --}}
            @if(! in_array($type, ['sejarah', 'visi_misi', 'stakeholder']))
            <!-- Additional Info -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="additional_info" class="block text-sm font-medium text-gray-700">{{ $fl['additional'] }} <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <button type="button" @click="previewAdditional = !previewAdditional"
                            class="text-xs font-medium text-pema-500 hover:text-pema-600 transition-colors inline-flex items-center gap-1">
                        <i class="fi" :class="previewAdditional ? 'fi-rs-edit' : 'fi-rs-eye'"></i>
                        <span x-text="previewAdditional ? 'Edit' : 'Preview'"></span>
                    </button>
                </div>
                <input type="hidden" id="additional_info" name="additional_info" value="{{ old('additional_info', $profile->additional_info) }}">
                <trix-editor input="additional_info" class="trix-content" placeholder="Informasi tambahan (jika ada)..."
                             @trix-change="additionalHtml = $event.target.value"
                             x-show="!previewAdditional"></trix-editor>
                <div x-show="previewAdditional" x-cloak
                     class="p-4 rounded-xl border border-gray-200 bg-gray-50 min-h-[100px] text-sm text-gray-700 leading-relaxed"
                     x-html="additionalHtml">
                </div>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1.5">Gambar <span class="text-gray-400 font-normal">(opsional)</span></label>
                @if($profile->image)
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-2">Gambar saat ini:</p>
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/' . $profile->image) }}"
                                 alt="{{ $profile->title }}"
                                 class="h-32 w-auto rounded-xl border border-gray-200 object-cover">
                        </div>
                    </div>
                @endif
                <input type="file" id="image" name="image"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-pema-50 file:text-pema-600 hover:file:bg-pema-100 transition-colors @error('image') border-red-300 @enderror">
                @error('image')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, WebP. Maksimal 2MB.</p>
            </div>
            @endif

            <!-- Foto Stakeholder (khusus Stakeholder) -->
@if($type === 'stakeholder')
<div class="pt-5 border-t border-gray-100">
    <label for="image_left" class="block text-sm font-medium text-gray-700 mb-1.5">
        Foto Stakeholder <span class="text-gray-400 font-normal">(opsional)</span>
    </label>
    @if($profile->image_left)
        <div class="mb-3">
            <p class="text-xs text-gray-500 mb-2">Gambar saat ini:</p>
            <img src="{{ asset('storage/' . $profile->image_left) }}"
                 class="h-32 w-auto rounded-xl border border-gray-200 object-cover">
        </div>
    @endif
    <input type="file" id="image_left" name="image_left"
           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-pema-50 file:text-pema-600 hover:file:bg-pema-100 transition-colors @error('image_left') border-red-300 @enderror">
    @error('image_left')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
    <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, WebP. Maksimal 2MB.</p>
</div>
@endif

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.profil.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    <i class="fi fi-rs-save text-sm"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection