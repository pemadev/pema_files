@extends('admin.layouts.master')

@section('title', $editMode ? 'Edit Bidang Bisnis' : 'Tambah Bidang Bisnis')
@section('page_title', $editMode ? 'Edit Bidang Bisnis' : 'Tambah Bidang Bisnis')

@section('content')
<div class="max-w-3xl">
    <form method="POST"
          x-data="{ files: [], previews: [], preview: false, contentHtml: '{{ addslashes(old('description', $business->description)) }}' }"
          @submit.prevent="
            dt = new DataTransfer();
            files.forEach(f => dt.items.add(f));
            $refs.fileInput.files = dt.files;
            $el.submit();
          "
          action="{{ $editMode ? route('admin.bisnis.update', $business) : route('admin.bisnis.store') }}"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if($editMode)
            @method('PUT')
        @endif

        <!-- Header Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-pema-50 flex items-center justify-center">
                    <i class="fi fi-rs-briefcase text-pema-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-gray-900">
                        {{ $editMode ? 'Edit: ' . $business->title : 'Informasi Bisnis Baru' }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ $editMode ? 'Perbarui data bidang bisnis' : 'Isi data bidang bisnis baru' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Fields -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="p-5 space-y-5">
            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                @if($categoryFromUrl)
                    <input type="hidden" name="category" value="{{ $categoryFromUrl }}">
                    <div class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-700">
                        <span class="inline-flex items-center gap-2">
                            @if($categoryFromUrl == 'migas')
                                <i class="fi fi-rs-oil-drip text-pema-500"></i> Migas
                            @elseif($categoryFromUrl == 'agroindustri')
                                <i class="fi fi-rs-leaf text-green-500"></i> Agroindustri
                            @elseif($categoryFromUrl == 'jasa')
                                <i class="fi fi-rs-settings text-blue-500"></i> Jasa
                            @endif
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Kategori ditentukan dari halaman sebelumnya.</p>
                @else
                    <select id="category" name="category"
                            class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('category') border-red-300 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="migas" {{ old('category', $business->category) == 'migas' ? 'selected' : '' }}>Migas</option>
                        <option value="agroindustri" {{ old('category', $business->category) == 'agroindustri' ? 'selected' : '' }}>Agroindustri</option>
                        <option value="jasa" {{ old('category', $business->category) == 'jasa' ? 'selected' : '' }}>Jasa</option>
                    </select>
                @endif
                @error('category')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">Judul Bisnis <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $business->title) }}"
                       class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('title') border-red-300 @enderror"
                       placeholder="Contoh: Komersialisasi Komoditi Kopi">
                <p class="mt-1 text-xs text-gray-400">Judul utama yang ditampilkan di kartu dan header halaman detail.</p>
                @error('title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subtitle -->
            <div>
                <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1.5">Judul Konten <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="text" id="subtitle" name="subtitle"
                       value="{{ old('subtitle', $business->subtitle) }}"
                       class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('subtitle') border-red-300 @enderror"
                       placeholder="Contoh: Kopi Gayo Premium">
                <p class="mt-1 text-xs text-gray-400">Judul tambahan yang ditampilkan sebelum deskripsi di halaman detail.</p>
                @error('subtitle')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        Konten / Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <button type="button" @click="preview = !preview"
                            class="text-xs font-medium text-pema-500 hover:text-pema-600 transition-colors inline-flex items-center gap-1">
                        <i class="fi" :class="preview ? 'fi-rs-edit' : 'fi-rs-eye'"></i>
                        <span x-text="preview ? 'Edit' : 'Preview'"></span>
                    </button>
                </div>
                <input type="hidden" id="description" name="description" value="{{ old('description', $business->description) }}">
                <trix-editor input="description" class="trix-content" placeholder="Tulis konten deskripsi bisnis di sini..." x-show="!preview"
                             @trix-change="contentHtml = $event.target.value"></trix-editor>
                <div x-show="preview" x-cloak
                     class="p-4 rounded-xl border border-gray-200 bg-gray-50 min-h-[180px] text-sm text-gray-700 leading-relaxed"
                     x-html="contentHtml">
                </div>
                <p class="mt-1 text-xs text-gray-400">Konten utama yang ditampilkan di halaman detail. Mendukung formatting HTML dari Trix editor.</p>
                @error('description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto <span class="text-gray-400 font-normal">(opsional, bisa pilih banyak)</span></label>
                @if($editMode && $business->images)
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $business->images) as $img)
                                <img src="{{ asset('storage/' . trim($img)) }}" alt="{{ $business->title }}"
                                     class="h-24 w-auto rounded-xl border border-gray-200 object-contain bg-gray-50">
                            @endforeach
                        </div>
                        <input type="hidden" name="existing_images" value="{{ $business->images }}">
                    </div>
                @elseif($editMode && $business->image)
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $business->image) }}" alt="{{ $business->title }}"
                             class="h-24 w-auto rounded-xl border border-gray-200 object-contain bg-gray-50">
                    </div>
                @endif

                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-pema-300 transition-colors cursor-pointer"
                     @click="$refs.fileInput.click()">
                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l2.409-2.409a2.25 2.25 0 013.182 0l2.409 2.409m-3-3.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-sm text-gray-500">Klik untuk pilih gambar</p>
                    <p class="text-xs text-gray-400 mt-1">Bisa pilih banyak, JPEG/PNG/WebP, maks 2MB per file</p>
                </div>

                <input type="file" id="images" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp"
                       class="hidden" x-ref="fileInput"
                       @change="
                        Array.from($event.target.files).forEach(f => { files.push(f); previews.push(URL.createObjectURL(f)); });
                        $event.target.value = '';
                       ">

                <template x-if="previews.length > 0">
                    <div class="mt-3">
                        <p class="text-xs font-medium text-gray-500 mb-2"><span x-text="previews.length"></span> gambar baru</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="(src, i) in previews" :key="i">
                                <div class="relative">
                                    <img :src="src" alt="Preview" class="h-24 w-auto rounded-xl border border-gray-200 object-contain bg-gray-50">
                                    <button type="button" @click="previews.splice(i,1); files.splice(i,1)"
                                            class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                @error('images') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                @error('images.*') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>



            <!-- Tags -->
            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-1.5">Tags <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="text" id="tags" name="tags"
                       value="{{ old('tags', $business->tags ? implode(', ', $business->tags) : '') }}"
                       class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('tags') border-red-300 @enderror"
                       placeholder="minyak, gas, energi">
                @error('tags')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Pisahkan dengan koma. Contoh: <code class="text-gray-500 bg-gray-50 px-1 rounded">minyak, gas, energi</code></p>
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1.5">Urutan <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="number" id="sort_order" name="sort_order"
                       value="{{ old('sort_order', $business->sort_order ?? 0) }}"
                       min="0"
                       class="block w-32 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('sort_order') border-red-300 @enderror">
                @error('sort_order')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Semakin kecil angka, semakin tampil di awal.</p>
            </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 px-5 pt-4 pb-5 border-t border-gray-100">
                <a href="{{ route('admin.bisnis.index', ['category' => $categoryFromUrl ?: $business->category]) }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    <i class="fi fi-rs-save"></i>
                    {{ $editMode ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
