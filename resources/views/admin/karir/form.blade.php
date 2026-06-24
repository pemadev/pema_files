@extends('admin.layouts.master')

@section('title', isset($job) ? 'Edit Lowongan' : 'Tambah Lowongan')
@section('page_title', isset($job) ? 'Edit Lowongan' : 'Tambah Lowongan')

@section('content')
<div class="max-w-3xl">
    <form action="{{ isset($job) ? route('admin.karir.update', $job) : route('admin.karir.store') }}"
          method="POST"
          enctype="multipart/form-data"
          x-data="{
              thumbnailPreview: '{{ isset($job) && $job->thumbnail ? asset('storage/' . $job->thumbnail) : '' }}'
          }"
          class="space-y-6">
        @csrf
        @if(isset($job))
            @method('PUT')
        @endif

        <!-- Header Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center gap-4 mb-1">
                <div class="w-12 h-12 rounded-xl bg-pema-50 flex items-center justify-center">
                    <i class="fi fi-rs-briefcase text-pema-500 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-heading font-semibold text-gray-900">{{ isset($job) ? 'Edit: ' . $job->title : 'Informasi Lowongan' }}</h3>
                    <p class="text-sm text-gray-500">{{ isset($job) ? 'Perbarui data lowongan' : 'Isi data lowongan baru' }}</p>
                </div>
            </div>
        </div>

        <!-- Form Fields -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="p-5 space-y-5">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">Judul Lowongan <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title"
                           value="{{ old('title', isset($job) ? $job->title : '') }}"
                           class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('title') border-red-300 @enderror"
                           placeholder="Contoh: Staff Administrasi">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department & Location -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-1.5">Departemen</label>
                        <input type="text" id="department" name="department"
                               value="{{ old('department', isset($job) ? $job->department : '') }}"
                               class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('department') border-red-300 @enderror"
                               placeholder="Contoh: HRD">
                        @error('department')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi</label>
                        <input type="text" id="location" name="location"
                               value="{{ old('location', isset($job) ? $job->location : '') }}"
                               class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('location') border-red-300 @enderror"
                               placeholder="Contoh: Banda Aceh">
                        @error('location')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Type & Salary -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Pekerjaan <span class="text-red-500">*</span></label>
                        <select id="type" name="type"
                                class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('type') border-red-300 @enderror">
                            <option value="fulltime" {{ old('type', isset($job) ? $job->type : '') == 'fulltime' ? 'selected' : '' }}>Full Time</option>
                            <option value="parttime" {{ old('type', isset($job) ? $job->type : '') == 'parttime' ? 'selected' : '' }}>Part Time</option>
                            <option value="contract" {{ old('type', isset($job) ? $job->type : '') == 'contract' ? 'selected' : '' }}>Kontrak</option>
                            <option value="internship" {{ old('type', isset($job) ? $job->type : '') == 'internship' ? 'selected' : '' }}>Magang</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="salary_range" class="block text-sm font-medium text-gray-700 mb-1.5">Range Gaji</label>
                        <input type="text" id="salary_range" name="salary_range"
                               value="{{ old('salary_range', isset($job) ? $job->salary_range : '') }}"
                               class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('salary_range') border-red-300 @enderror"
                               placeholder="Contoh: 5-8 juta/bulan">
                        @error('salary_range')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1.5">Deadline Pendaftaran</label>
                    <input type="date" id="deadline" name="deadline"
                           value="{{ old('deadline', isset($job) && $job->deadline ? $job->deadline->format('Y-m-d') : '') }}"
                           class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('deadline') border-red-300 @enderror">
                    @error('deadline')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Pekerjaan</label>
                    <textarea id="description" name="description" rows="4"
                              class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('description') border-red-300 @enderror resize-none"
                              placeholder="Jelaskan deskripsi pekerjaan...">{{ old('description', isset($job) ? $job->description : '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Requirements -->
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1.5">Persyaratan</label>
                    <textarea id="requirements" name="requirements" rows="4"
                              class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('requirements') border-red-300 @enderror resize-none"
                              placeholder="Tuliskan persyaratan lowongan...">{{ old('requirements', isset($job) ? $job->requirements : '') }}</textarea>
                    @error('requirements')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Google Form Link -->
                <div>
                    <label for="google_form_link" class="block text-sm font-medium text-gray-700 mb-1.5">Link Google Form</label>
                    <input type="url" id="google_form_link" name="google_form_link"
                           value="{{ old('google_form_link', isset($job) ? $job->google_form_link : '') }}"
                           class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-pema-500 focus:border-pema-500 @error('google_form_link') border-red-300 @enderror"
                           placeholder="https://docs.google.com/forms/d/...">
                    @error('google_form_link')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-400">Link Google Form untuk pendaftaran (opsional)</p>
                </div>

                <!-- Thumbnail -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Thumbnail</label>
                    <div x-show="thumbnailPreview" class="mb-3">
                        <img :src="thumbnailPreview" alt="Preview" class="h-32 w-auto rounded-xl border border-gray-200 object-cover">
                        <button type="button" @click="thumbnailPreview = ''" class="mt-2 text-xs text-red-500 hover:text-red-600">
                            <i class="fi fi-rs-trash"></i> Hapus preview
                        </button>
                    </div>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-pema-50 file:text-pema-600 hover:file:bg-pema-100 @error('thumbnail') border-red-300 @enderror"
                           @change="if($event.target.files[0]) thumbnailPreview = URL.createObjectURL($event.target.files[0])">
                    <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG, WebP. Maksimal 2MB.</p>
                    @error('thumbnail')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', isset($job) ? $job->is_active : true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 text-pema-500 focus:ring-pema-500">
                        <span class="text-sm font-medium text-gray-700">Aktifkan lowongan</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-400 ml-7">Jika tidak dicentang, lowongan hanya tersimpan sebagai draft.</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 px-5 pt-4 pb-5 border-t border-gray-100">
                <a href="{{ route('admin.karir.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    <i class="fi fi-rs-save"></i>
                    {{ isset($job) ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
