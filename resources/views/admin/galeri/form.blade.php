@extends('admin.layouts.master')

@section('title', isset($gallery) ? 'Edit Galeri' : 'Tambah Galeri')
@section('page_title', isset($gallery) ? 'Edit Galeri' : 'Tambah Galeri')

@section('content')
<div class="max-w-2xl">
    <form action="{{ isset($gallery) ? route('admin.galeri.update', $gallery) : route('admin.galeri.store') }}"
          method="POST"
          enctype="multipart/form-data"
          x-data="{ files: [], previews: [] }"
          @submit.prevent="
            dt = new DataTransfer();
            files.forEach(f => dt.items.add(f));
            $refs.fileInput.files = dt.files;
            $el.submit();
          "
          class="space-y-6">
        @csrf
        @if(isset($gallery))
            @method('PUT')
        @endif

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="font-heading font-semibold text-gray-900 text-sm">
                    {{ isset($gallery) ? 'Edit data galeri' : 'Informasi Galeri' }}
                </h3>
            </div>
            <div class="px-6 py-5 space-y-5">
                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title', isset($gallery) ? $gallery->title : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm @error('title') border-red-300 bg-red-50 @enderror"
                           placeholder="Masukkan judul galeri">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Images --}}
                <div x-data="{ removeAll: false }">
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Gambar @if(!isset($gallery))<span class="text-red-500">*</span>@endif
                    </label>
                    @if(isset($gallery) && $gallery->image)
                        <div class="mb-3" x-show="!removeAll">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs text-gray-400">Gambar saat ini ({{ count(explode(',', $gallery->image)) }} gambar):</p>
                                <button type="button" @click="removeAll = true; document.getElementById('existing_images').value = '';"
                                        class="text-xs text-red-500 hover:text-red-600 font-medium">
                                    <i class="fi fi-rs-trash"></i> Hapus Semua
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $gallery->image) as $img)
                                    @php $imgPath = trim($img); @endphp
                                    <div x-data="{ removed: false }" x-show="!removed" class="relative">
                                        <img src="{{ asset('storage/' . $imgPath) }}"
                                             alt="{{ $gallery->title }}"
                                             class="w-32 h-24 object-contain bg-gray-50 rounded-xl border border-gray-100"
                                             onerror="this.onerror=null;this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%23d1d5db%22><path d=%22M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l2.409-2.409a2.25 2.25 0 013.182 0l2.409 2.409m-3-3.75a3 3 0 11-6 0 3 3 0 016 0z%22/></svg>'">
                                        <button type="button" @click="removed = true; $dispatch('remove-existing', '{{ $imgPath }}')"
                                                class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="existing_images" id="existing_images" value="{{ $gallery->image }}">
                            <input type="hidden" name="remove_images" id="remove_images" value="">
                        </div>
                        <div x-show="removeAll" class="mb-3 p-3 bg-red-50 rounded-xl border border-red-200">
                            <p class="text-sm text-red-600"><i class="fi fi-rs-warning"></i> Semua gambar akan dihapus saat disimpan.</p>
                            <button type="button" @click="removeAll = false; document.getElementById('existing_images').value = '{{ $gallery->image }}';"
                                    class="text-xs text-red-500 hover:text-red-600 font-medium mt-1">
                                Batalkan
                            </button>
                        </div>
                        <script>
                            document.addEventListener('remove-existing', function(e) {
                                var removeInput = document.getElementById('remove_images');
                                var paths = removeInput.value ? removeInput.value.split(',') : [];
                                paths.push(e.detail);
                                removeInput.value = paths.join(',');
                                // Update existing_images to exclude removed
                                var existing = document.getElementById('existing_images').value.split(',');
                                var filtered = existing.filter(function(p) { return p.trim() !== e.detail; });
                                document.getElementById('existing_images').value = filtered.join(',');
                            });
                        </script>
                    @endif

                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-pema-300 transition-colors cursor-pointer"
                         @click="$refs.fileInput.click()">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l2.409-2.409a2.25 2.25 0 013.182 0l2.409 2.409m-3-3.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-sm text-gray-500">Klik atau tarik gambar ke sini</p>
                        <p class="text-xs text-gray-400 mt-1">Bisa pilih banyak gambar sekaligus atau bertahap</p>
                    </div>

                    <input type="file"
                           id="images"
                           name="images[]"
                           multiple
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="hidden"
                           x-ref="fileInput"
                           @change="
                            newFiles = Array.from($event.target.files);
                            newFiles.forEach(f => { files.push(f); previews.push(URL.createObjectURL(f)); });
                            $event.target.value = '';
                           ">

                    <template x-if="previews.length > 0">
                        <div class="mt-3">
                            <p class="text-xs font-medium text-gray-500 mb-2">
                                <span x-text="previews.length"></span> gambar baru dipilih
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="(src, i) in previews" :key="i">
                                    <div class="relative">
                                        <img :src="src" alt="Preview"
                                             class="w-32 h-24 object-contain bg-gray-50 rounded-xl border border-gray-200">
                                        <button type="button" @click="previews.splice(i,1); files.splice(i,1)"
                                                class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    @error('images')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Caption --}}
                <div>
                    <label for="caption" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Caption
                    </label>
                    <textarea id="caption"
                              name="caption"
                              rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm resize-none @error('caption') border-red-300 bg-red-50 @enderror"
                              placeholder="Masukkan caption (opsional)">{{ old('caption', isset($gallery) ? $gallery->caption : '') }}</textarea>
                    @error('caption')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sort Order --}}
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Urutan
                    </label>
                    <input type="number"
                           id="sort_order"
                           name="sort_order"
                           value="{{ old('sort_order', isset($gallery) ? $gallery->sort_order : '') }}"
                           min="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm @error('sort_order') border-red-300 bg-red-50 @enderror"
                           placeholder="0">
                    @error('sort_order')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 px-6 pt-4 pb-5 border-t border-gray-100">
                <a href="{{ route('admin.galeri.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    {{ isset($gallery) ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
