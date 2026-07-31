@extends('admin.layouts.master')

@section('title', isset($report) ? 'Edit Laporan' : 'Tambah Laporan')
@section('page_title', isset($report) ? 'Edit Laporan' : 'Tambah Laporan')

@section('content')
<div class="max-w-2xl" x-data="{
    filePreview: '',
    fileName: '',
    fileType: '',
    @if(isset($report) && $report->file)
        existingFile: '{{ $report->file }}'
    @else
        existingFile: ''
    @endif
}">
    <form action="{{ isset($report) ? route('admin.laporan.update', $report) : route('admin.laporan.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if(isset($report))
            @method('PUT')
        @endif

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="font-heading font-semibold text-gray-900 text-sm">
                    {{ isset($report) ? 'Edit data laporan' : 'Informasi Laporan' }}
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
                           value="{{ old('title', isset($report) ? $report->title : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm @error('title') border-red-300 bg-red-50 @enderror"
                           placeholder="Masukkan judul laporan">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- File --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        File @if(!isset($report))<span class="text-red-500">*</span>@endif
                    </label>
                    
                    {{-- Existing file link --}}
                    <template x-if="existingFile && !filePreview">
                        <div class="mb-3 p-3 bg-gray-50 rounded-xl flex items-center gap-3">
                            <i class="fi fi-rs-file-pdf text-pema-500 text-lg"></i>
                            <div class="flex-1">
                                <a :href="'{{ route('admin.laporan.file', ['report' => '__ID__']) }}'.replace('__ID__', '{{ isset($report) ? $report->id : '' }}')"
                                   target="_blank"
                                   class="text-sm text-pema-500 hover:text-pema-600 font-medium">
                                    Lihat file saat ini
                                </a>
                                <p class="text-xs text-gray-400">Pilih file baru untuk mengganti</p>
                            </div>
                            <button type="button" 
                                    @click="existingFile = ''; filePreview = ''; fileName = ''; fileType = ''"
                                    class="text-xs text-red-500 hover:text-red-600">
                                <i class="fi fi-rs-trash"></i> Hapus
                            </button>
                        </div>
                    </template>

                    {{-- File input area --}}
                    <div class="border-2 border-dashed rounded-xl p-6 text-center cursor-pointer transition-colors"
                         :class="filePreview ? 'border-pema-300 bg-pema-50/50' : 'border-gray-200 hover:border-pema-300 bg-gray-50'"
                         @click="$refs.fileInput.click()">
                        
                        {{-- No file selected --}}
                        <template x-if="!filePreview && !existingFile">
                            <div>
                                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-pema-100 flex items-center justify-center">
                                    <i class="fi fi-rs-upload text-pema-500 text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-600 font-medium">Klik untuk pilih file</p>
                                <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX, XLS, XLSX (Maks 10MB)</p>
                            </div>
                        </template>
                        
                        {{-- File selected - show preview --}}
                        <template x-if="filePreview">
                            <div class="text-left">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <i :class="fileType === 'pdf' ? 'fi fi-rs-file-pdf text-red-500' : 'fi fi-rs-file text-blue-500'" class="text-lg"></i>
                                        <span class="text-sm font-medium text-gray-700" x-text="fileName"></span>
                                        <span class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Terpilih</span>
                                    </div>
                                    <button type="button" 
                                            @click.stop="filePreview = ''; fileName = ''; fileType = ''; $refs.fileInput.value = ''"
                                            class="text-xs text-red-500 hover:text-red-600 px-2 py-1 rounded hover:bg-red-50">
                                        <i class="fi fi-rs-trash"></i> Hapus
                                    </button>
                                </div>
                                <template x-if="fileType === 'pdf'">
                                    <iframe :src="filePreview" class="w-full h-80 rounded-lg border border-gray-200 bg-white"></iframe>
                                </template>
                                <template x-if="fileType !== 'pdf'">
                                    <div class="p-8 bg-white rounded-lg border border-gray-200 text-center">
                                        <div class="w-16 h-16 mx-auto mb-3 rounded-xl bg-blue-50 flex items-center justify-center">
                                            <i class="fi fi-rs-file text-blue-500 text-2xl"></i>
                                        </div>
                                        <p class="text-sm text-gray-600">File dipilih</p>
                                        <p class="text-xs text-gray-400 mt-1">Preview hanya tersedia untuk PDF</p>
                                    </div>
                                </template>
                            </div>
                        </template>

                        {{-- File selected but no preview (non-PDF) --}}
                        <template x-if="!filePreview && existingFile">
                            <div>
                                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-pema-100 flex items-center justify-center">
                                    <i class="fi fi-rs-file-pdf text-pema-500 text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-600 font-medium">Klik untuk ganti file</p>
                                <p class="text-xs text-gray-400 mt-1">Pilih file baru akan mengganti file lama</p>
                            </div>
                        </template>
                    </div>

                    <input type="file"
                           id="file"
                           name="file"
                           x-ref="fileInput"
                           accept=".pdf,.doc,.docx,.xls,.xlsx"
                           class="hidden"
                           @change="handleFileSelect($event)">
                    
                    <p class="mt-1.5 text-xs text-gray-400">Format: PDF, DOC, DOCX, XLS, XLSX. Maksimal 10MB.</p>
                    @error('file')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Year --}}
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="year"
                           name="year"
                           value="{{ old('year', isset($report) ? $report->year : date('Y')) }}"
                           min="2000"
                           max="{{ date('Y') + 1 }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm @error('year') border-red-300 bg-red-50 @enderror"
                           placeholder="{{ date('Y') }}">
                    @error('year')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Deskripsi
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm resize-none @error('description') border-red-300 bg-red-50 @enderror"
                              placeholder="Masukkan deskripsi (opsional)">{{ old('description', isset($report) ? $report->description : '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Is Published --}}
                <div>
                    <label class="flex items-center gap-3">
                        <input type="checkbox"
                               name="is_published"
                               value="1"
                               {{ old('is_published', isset($report) ? $report->is_published : true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 text-pema-500 focus:ring-pema-500">
                        <span class="text-sm font-medium text-gray-700">Publikasikan laporan</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-400 ml-7">Jika tidak dicentang, laporan hanya tersimpan sebagai draft.</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 px-6 pt-4 pb-5 border-t border-gray-100">
                <a href="{{ route('admin.laporan.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    {{ isset($report) ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('fileUpload', () => ({
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const fileName = file.name;
            const fileExt = fileName.split('.').pop().toLowerCase();
            
            this.fileName = fileName;
            this.fileType = fileExt;
            
            if (fileExt === 'pdf') {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.filePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.filePreview = '';
            }
        }
    }));
});

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    const fileName = file.name;
    const fileExt = fileName.split('.').pop().toLowerCase();
    
    // Access Alpine component data
    const component = Alpine.$data(event.target.closest('[x-data]'));
    if (component) {
        component.fileName = fileName;
        component.fileType = fileExt;
        
        if (fileExt === 'pdf') {
            const reader = new FileReader();
            reader.onload = (e) => {
                component.filePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            component.filePreview = '';
        }
    }
}
</script>
@endsection
