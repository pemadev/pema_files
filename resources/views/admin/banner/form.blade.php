@extends('admin.layouts.master')

@section('title', $banner->exists ? 'Edit Banner' : 'Tambah Banner')
@section('page_title', $banner->exists ? 'Edit Banner' : 'Tambah Banner')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ $banner->exists ? route('admin.banner.update', $banner) : route('admin.banner.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($banner->exists) @method('PUT') @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center"><i class="fi fi-rs-images text-pema-500 text-sm"></i></div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">{{ $banner->exists ? 'Edit Banner' : 'Informasi Banner Baru' }}</h3>
            </div>
            <div class="p-5 space-y-5">
                <div x-data="{ preview: '' }">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1.5">Gambar <span class="text-red-400">*</span></label>
                    @if($banner->exists && $banner->image)
                        <div class="mb-3"><img src="{{ asset('storage/' . $banner->image) }}" class="h-32 w-auto rounded-xl border border-gray-200 object-contain bg-gray-50"></div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : ''"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-pema-50 file:text-pema-600 hover:file:bg-pema-100 transition-all @error('image') border border-red-300 rounded-xl @enderror">
                    @error('image') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, WebP. Maks: 5MB.</p>
                    <p class="text-xs text-gray-400">Rekomendasi ukuran: <strong>800×800 piksel</strong> (rasio 1:1).</p>
                    <template x-if="preview">
                        <div class="mt-3">
                            <p class="text-xs font-medium text-gray-500 mb-2">Preview:</p>
                            <img :src="preview" alt="Preview" class="h-32 w-auto rounded-xl border border-gray-200 object-contain bg-gray-50">
                        </div>
                    </template>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">Judul <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $banner->title) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all"
                           placeholder="Judul banner (tidak ditampilkan)">
                    @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1.5">Urutan</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" min="0"
                           class="w-32 px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all">
                    @error('sort_order') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-pema-500 focus:ring-pema-500">
                    <label for="is_active" class="text-sm text-gray-700">Aktif</label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-5 pt-4 pb-5 border-t border-gray-100">
                <a href="{{ route('admin.banner.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    <i class="fi fi-rs-save"></i> {{ $banner->exists ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
