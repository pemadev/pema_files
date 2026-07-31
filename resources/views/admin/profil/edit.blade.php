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
