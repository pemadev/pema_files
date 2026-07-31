@extends('admin.layouts.master')

@section('title', 'Statistik Beranda')
@section('page_title', 'Statistik Beranda')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-pema-50 flex items-center justify-center flex-shrink-0">
                <i class="fi fi-rs-stats text-pema-500 text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Statistik Beranda</h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola angka pencapaian yang tampil di halaman depan website</p>
            </div>
        </div>

        <a href="{{ route('admin.statistik.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-pema-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-pema-500/30 hover:bg-pema-600 hover:shadow-md hover:shadow-pema-500/30 active:scale-[0.98] transition-all">
            <i class="fi fi-rs-plus-small text-base"></i>
            Tambah Statistik
        </a>
    </div>

    {{-- Ringkasan --}}
    @php
        $total = $statistik->count();
        $aktifCount = $statistik->where('is_active', true)->count();
        $nonaktifCount = $total - $aktifCount;
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-3.5 shadow-sm shadow-gray-100/50">
            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                <i class="fi fi-rs-list text-gray-500"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900 leading-none">{{ $total }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Statistik</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-3.5 shadow-sm shadow-gray-100/50">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <i class="fi fi-rs-check-circle text-emerald-500"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900 leading-none">{{ $aktifCount }}</p>
                <p class="text-xs text-gray-500 mt-1">Tampil di Beranda</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-3.5 shadow-sm shadow-gray-100/50">
            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                <i class="fi fi-rs-eye-crossed text-gray-400"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900 leading-none">{{ $nonaktifCount }}</p>
                <p class="text-xs text-gray-500 mt-1">Disembunyikan</p>
            </div>
        </div>
    </div>

    {{-- Flash message (fallback jika toast global di layout belum menangkap key 'status') --}}
    @if (session('status'))
        <div class="rounded-xl bg-emerald-50 border border-emerald-100 px-4 py-3 text-sm text-emerald-700 flex items-center gap-2.5">
            <i class="fi fi-rs-check-circle text-emerald-500"></i>
            {{ session('status') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm shadow-gray-100/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100">
                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 w-16">Urutan</th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500">Label</th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500">Nilai Tampil</th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-5 py-3.5 text-right text-[11px] font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($statistik as $item)
                        <tr class="group hover:bg-pema-50/40 transition-colors">
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold group-hover:bg-white transition-colors">
                                    {{ $item->urutan }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-800">{{ $item->label }}</p>
                                @if ($item->deskripsi)
                                    <p class="text-xs text-gray-400 mt-0.5 line-clamp-1 max-w-xs">{{ $item->deskripsi }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-semibold text-gray-900 tabular-nums">
                                    {{ $item->prefix }}{{ $item->value_formatted }}{{ $item->suffix }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if ($item->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500 ring-1 ring-inset ring-gray-400/10">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.statistik.edit', $item) }}"
                                       title="Edit"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-pema-600 hover:bg-pema-50 transition-colors">
                                        <i class="fi fi-rs-pencil text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.statistik.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus statistik &quot;{{ $item->label }}&quot;?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                            <i class="fi fi-rs-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center mb-3">
                                        <i class="fi fi-rs-stats text-2xl text-gray-300"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-600">Belum ada data statistik</p>
                                    <p class="text-xs text-gray-400 mt-1">Tambahkan angka pencapaian pertama untuk ditampilkan di beranda</p>
                                    <a href="{{ route('admin.statistik.create') }}"
                                       class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-pema-600 hover:text-pema-700">
                                        <i class="fi fi-rs-plus-small"></i>
                                        Tambah Statistik
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection