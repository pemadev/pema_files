@extends('admin.layouts.master')

@section('title', $item->exists ? 'Edit Statistik' : 'Tambah Statistik')
@section('page_title', $item->exists ? 'Edit Statistik' : 'Tambah Statistik')

@section('content')
<div class="max-w-5xl mx-auto space-y-6"
     x-data="{
        label: {{ Js::from(old('label', $item->label ?? '')) }},
        value: {{ Js::from(old('value', $item->value ?? '')) }},
        prefix: {{ Js::from(old('prefix', $item->prefix ?? '')) }},
        suffix: {{ Js::from(old('suffix', $item->suffix ?? '')) }},
        decimals: {{ Js::from(old('decimals', $item->decimals ?? 0)) }},
        deskripsi: {{ Js::from(old('deskripsi', $item->deskripsi ?? '')) }},
        isActive: {{ Js::from(old('is_active', $item->is_active ?? true)) }},
        get formatted() {
            const n = parseFloat(this.value);
            if (isNaN(n)) return '0';
            return n.toLocaleString('id-ID', {
                minimumFractionDigits: parseInt(this.decimals) || 0,
                maximumFractionDigits: parseInt(this.decimals) || 0,
            });
        }
     }">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.statistik.index') }}"
           class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 text-gray-400 hover:text-pema-600 hover:border-pema-200 hover:bg-pema-50 transition-colors flex-shrink-0">
            <i class="fi fi-rs-arrow-small-left text-base"></i>
        </a>
        <div class="w-12 h-12 rounded-2xl bg-pema-50 flex items-center justify-center flex-shrink-0">
            <i class="fi fi-rs-stats text-pema-500 text-lg"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">
                {{ $item->exists ? 'Edit Statistik' : 'Tambah Statistik' }}
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">
                {{ $item->exists ? 'Perbarui angka pencapaian yang tampil di beranda' : 'Tambahkan angka pencapaian baru ke halaman beranda' }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

        {{-- Form --}}
        <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 shadow-sm shadow-gray-100/50 p-6">
            <form action="{{ $item->exists ? route('admin.statistik.update', $item) : route('admin.statistik.store') }}"
                  method="POST" class="space-y-6">
                @csrf
                @if ($item->exists) @method('PUT') @endif

                {{-- Label --}}
                <div>
                    <label for="label" class="block text-sm font-semibold text-gray-700 mb-1.5">Label</label>
                    <input type="text" id="label" name="label" x-model="label"
                           class="w-full rounded-xl border-gray-200 text-sm text-gray-800 placeholder:text-gray-400 focus:border-pema-500 focus:ring focus:ring-pema-500/10 transition-shadow"
                           placeholder="mis. Anak Perusahaan & Unit Bisnis">
                    @error('label') <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1"><i class="fi fi-rs-exclamation"></i> {{ $message }}</p> @enderror
                </div>

                {{-- Value, Prefix, Suffix --}}
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="value" class="block text-sm font-semibold text-gray-700 mb-1.5">Nilai</label>
                        <input type="number" step="0.01" id="value" name="value" x-model="value"
                               class="w-full rounded-xl border-gray-200 text-sm text-gray-800 placeholder:text-gray-400 focus:border-pema-500 focus:ring focus:ring-pema-500/10 transition-shadow"
                               placeholder="12">
                        @error('value') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="prefix" class="block text-sm font-semibold text-gray-700 mb-1.5">Prefix</label>
                        <input type="text" id="prefix" name="prefix" x-model="prefix"
                               class="w-full rounded-xl border-gray-200 text-sm text-gray-800 placeholder:text-gray-400 focus:border-pema-500 focus:ring focus:ring-pema-500/10 transition-shadow"
                               placeholder="Rp ">
                    </div>
                    <div>
                        <label for="suffix" class="block text-sm font-semibold text-gray-700 mb-1.5">Suffix</label>
                        <input type="text" id="suffix" name="suffix" x-model="suffix"
                               class="w-full rounded-xl border-gray-200 text-sm text-gray-800 placeholder:text-gray-400 focus:border-pema-500 focus:ring focus:ring-pema-500/10 transition-shadow"
                               placeholder="%, +, T">
                    </div>
                </div>

                {{-- Decimals, Urutan --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="decimals" class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah Desimal</label>
                        <input type="number" min="0" max="3" id="decimals" name="decimals" x-model="decimals"
                               class="w-full rounded-xl border-gray-200 text-sm text-gray-800 focus:border-pema-500 focus:ring focus:ring-pema-500/10 transition-shadow">
                    </div>
                    <div>
                        <label for="urutan" class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampil</label>
                        <input type="number" min="0" id="urutan" name="urutan"
                               value="{{ old('urutan', $item->urutan ?? 0) }}"
                               class="w-full rounded-xl border-gray-200 text-sm text-gray-800 focus:border-pema-500 focus:ring focus:ring-pema-500/10 transition-shadow">
                        <p class="mt-1.5 text-xs text-gray-400">Angka lebih kecil tampil lebih dulu</p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Singkat</label>
                    <textarea id="deskripsi" name="deskripsi" rows="2" x-model="deskripsi"
                              class="w-full rounded-xl border-gray-200 text-sm text-gray-800 placeholder:text-gray-400 focus:border-pema-500 focus:ring focus:ring-pema-500/10 transition-shadow"
                              placeholder="Kalimat penjelas di bawah angka"></textarea>
                    <p class="mt-1.5 text-xs text-gray-400"><span x-text="deskripsi.length"></span>/255 karakter</p>
                </div>

                {{-- Toggle Aktif --}}
                <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-gray-50/60 px-4 py-3.5">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Tampilkan di Beranda</p>
                        <p class="text-xs text-gray-400 mt-0.5">Nonaktifkan untuk menyembunyikan tanpa menghapus data</p>
                    </div>
                    <button type="button" @click="isActive = !isActive"
                            :class="isActive ? 'bg-pema-500' : 'bg-gray-300'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors flex-shrink-0">
                        <span :class="isActive ? 'translate-x-5' : 'translate-x-1'"
                              class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                    </button>
                    <input type="hidden" name="is_active" :value="isActive ? 1 : 0">
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-2 border-t border-gray-50">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-pema-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-pema-500/30 hover:bg-pema-600 active:scale-[0.98] transition-all mt-4">
                        <i class="fi fi-rs-check text-sm"></i>
                        Simpan
                    </button>
                    <a href="{{ route('admin.statistik.index') }}"
                       class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors mt-4">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Live Preview --}}
        <div class="lg:col-span-2 lg:sticky lg:top-20">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3 px-1">Pratinjau di Beranda</p>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm shadow-gray-100/50 p-6">
                <div class="relative pl-5 border-l-2 border-pema-100">
                    <p class="text-sm font-medium text-gray-500" x-text="label || 'Label statistik'"></p>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900">
                        <span x-text="prefix"></span><span x-text="formatted"></span><span x-text="suffix"></span>
                    </p>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed" x-text="deskripsi || 'Deskripsi singkat akan tampil di sini.'"></p>
                </div>

                <div class="mt-5 pt-4 border-t border-gray-50 flex items-center gap-2">
                    <span x-show="isActive" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Akan tampil di beranda
                    </span>
                    <span x-show="!isActive" class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                        Disembunyikan
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection