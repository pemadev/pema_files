@extends('admin.layouts.master')

@section('title', isset($news) ? 'Edit Pengumuman' : 'Tambah Pengumuman')
@section('page_title', isset($news) ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <h4 class="font-heading font-semibold text-gray-900">
                {{ isset($news) ? 'Form Edit Pengumuman' : 'Form Tambah Pengumuman' }}
            </h4>
        </div>

        {{-- Form --}}
        <form action="{{ isset($news) ? route('admin.pengumuman.update', $news) : route('admin.pengumuman.store') }}"
              method="POST"
              enctype="multipart/form-data"
              x-data="{ preview: false, contentHtml: '{{ old('content', isset($news) ? $news->content : '') }}' }"
              class="p-6 space-y-6">
            @csrf
            @if(isset($news))
                @method('PUT')
            @endif

            {{-- Type hidden --}}
            <input type="hidden" name="type" value="pengumuman">

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title', isset($news) ? $news->title : '') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-pema-500 focus:ring-2 focus:ring-pema-100 outline-none transition-all text-sm @error('title') border-red-300 bg-red-50 @enderror"
                       placeholder="Masukkan judul pengumuman">
                @error('title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="content" class="block text-sm font-medium text-gray-700">
                        Konten <span class="text-red-500">*</span>
                    </label>
                    <button type="button" @click="preview = !preview"
                            class="text-xs font-medium text-pema-500 hover:text-pema-600 transition-colors inline-flex items-center gap-1">
                        <i class="fi" :class="preview ? 'fi-rs-edit' : 'fi-rs-eye'"></i>
                        <span x-text="preview ? 'Edit' : 'Preview'"></span>
                    </button>
                </div>
                <input type="hidden" id="content" name="content" value="{{ old('content', isset($news) ? $news->content : '') }}">
                <trix-editor input="content" class="trix-content" placeholder="Masukkan konten pengumuman..." x-show="!preview"
                             @trix-change="contentHtml = $event.target.value"></trix-editor>
                <div x-show="preview" x-cloak
                     class="p-4 rounded-xl border border-gray-200 bg-gray-50 min-h-[180px] text-sm text-gray-700 leading-relaxed whitespace-pre-wrap"
                     x-html="contentHtml">
                </div>
                @error('content')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Date & Author --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="date"
                           name="date"
                           value="{{ old('date', isset($news) ? $news->date->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-pema-500 focus:ring-2 focus:ring-pema-100 outline-none transition-all text-sm @error('date') border-red-300 bg-red-50 @enderror">
                    @error('date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Penulis <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="author"
                           name="author"
                           value="{{ old('author', isset($news) ? $news->author : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-pema-500 focus:ring-2 focus:ring-pema-100 outline-none transition-all text-sm @error('author') border-red-300 bg-red-50 @enderror"
                           placeholder="Nama penulis">
                    @error('author')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Image --}}
            <div x-data="{ imagePreview: '', removeCurrent: false }">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gambar
                </label>

                @if(isset($news) && $news->image)
                    <div class="mb-3" x-show="!removeCurrent">
                        <div class="flex items-start gap-3">
                            <img src="{{ asset('storage/' . $news->image) }}"
                                 alt="{{ $news->title }}"
                                 class="w-48 h-32 object-contain bg-gray-50 rounded-xl border border-gray-200">
                            <button type="button" @click="removeCurrent = true"
                                    class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors mt-1">
                                <i class="fi fi-rs-trash text-xs"></i> Hapus
                            </button>
                        </div>
                        <input type="hidden" name="remove_image" value="0" x-model="removeCurrent ? '1' : '0'">
                    </div>
                @endif

                <input type="file"
                       id="image"
                       name="image"
                       accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                       @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-pema-500 focus:ring-2 focus:ring-pema-100 outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-pema-50 file:text-pema-600 hover:file:bg-pema-100 @error('image') border-red-300 bg-red-50 @enderror">
                <p class="mt-1.5 text-xs text-gray-400">Format: JPG, PNG, GIF, WebP. Maks. 2MB.</p>
                <template x-if="imagePreview">
                    <div class="mt-3">
                        <p class="text-xs font-medium text-gray-500 mb-2">Preview:</p>
                        <img :src="imagePreview" alt="Preview"
                             class="w-48 h-32 object-contain bg-gray-50 rounded-xl border border-gray-200">
                    </div>
                </template>
                @error('image')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Document --}}
            <div x-data="{ docPreview: '' }">
                <label for="document" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Dokumen Lampiran <span class="text-gray-400 font-normal">(opsional)</span>
                </label>

                @if(isset($news) && $news->document_path)
                    <div class="mb-3 p-3 bg-gray-50 rounded-xl flex items-center gap-3">
                        <i class="fi fi-rs-file text-pema-500 text-lg"></i>
                        <div class="flex-1">
                            <a href="{{ asset('storage/' . $news->document_path) }}"
                               target="_blank"
                               class="text-sm text-pema-500 hover:text-pema-600 font-medium">
                                {{ $news->document_name }}
                            </a>
                            <p class="text-xs text-gray-400">Kosongkan jika tidak ingin mengganti dokumen</p>
                        </div>
                    </div>
                @endif

                <input type="file"
                       id="document"
                       name="document"
                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-pema-500 focus:ring-2 focus:ring-pema-100 outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-pema-50 file:text-pema-600 hover:file:bg-pema-100 @error('document') border-red-300 bg-red-50 @enderror">
                <p class="mt-1.5 text-xs text-gray-400">Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maks. 10MB.</p>
                @error('document')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Published --}}
            <div>
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox"
                           name="is_published"
                           value="1"
                           {{ old('is_published', isset($news) ? $news->is_published : false) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-pema-500 focus:ring-pema-500">
                    <span class="text-sm font-medium text-gray-700">Publikasikan</span>
                </label>
                <p class="mt-1 text-xs text-gray-400 ml-7">
                    Jika tidak dicentang, pengumuman akan disimpan sebagai draf.
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.pengumuman.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    {{ isset($news) ? 'Simpan Perubahan' : 'Simpan Pengumuman' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
