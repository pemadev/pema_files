@extends('admin.layouts.master')

@section('title', 'Daftar Pemohon')
@section('page_title', 'Daftar Pemohon')

@php
    $field = 'h-11 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 shadow-sm transition-all duration-200 hover:border-pema-300 focus:border-pema-400 focus:outline-none focus:ring-4 focus:ring-pema-500/15';
    $btn = 'inline-flex h-11 items-center justify-center gap-2 whitespace-nowrap rounded-xl px-4 text-sm font-medium transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 active:scale-95';
@endphp

@section('content')
<div class="p-6 space-y-6">
    <div>
        <h1 class="font-heading text-xl font-semibold text-gray-900">Daftar Pemohon</h1>
        <p class="text-sm text-gray-500 mt-0.5">Akun yang terdaftar di portal PPID</p>
    </div>

    <div class="grid grid-cols-2 gap-4 sm:max-w-md">
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs text-gray-400">Total akun</p>
            <p class="text-lg font-heading font-semibold text-gray-900 tabular-nums">{{ number_format($total, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
            <p class="text-xs text-gray-400">Akun aktif</p>
            <p class="text-lg font-heading font-semibold text-gray-900 tabular-nums">{{ number_format($aktif, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <form method="GET" action="{{ route('ppid.akun.index') }}" class="flex flex-col gap-3 border-b border-gray-100 p-4 sm:p-5 lg:flex-row lg:items-center">
            <div class="relative min-w-0 flex-1">
                <label class="sr-only" for="q">Cari</label>
                <i class="fi fi-rs-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input id="q" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama, email, telepon, atau no. KTP" autocomplete="off"
                       class="{{ $field }} w-full pl-11 pr-4 placeholder:text-gray-400">
            </div>
            <div class="flex flex-wrap gap-3">
                <label class="sr-only" for="kategori">Kategori</label>
                <select id="kategori" name="kategori" class="{{ $field }} cursor-pointer px-4" onchange="this.form.submit()">
                    <option value="">Semua kategori</option>
                    @foreach ($kategori as $id => $label)
                        <option value="{{ $id }}" @selected(($filters['kategori'] ?? '') == $id)>{{ $label }}</option>
                    @endforeach
                </select>
                <label class="sr-only" for="aktif">Status akun</label>
                <select id="aktif" name="aktif" class="{{ $field }} cursor-pointer px-4" onchange="this.form.submit()">
                    <option value="">Semua status</option>
                    <option value="1" @selected(($filters['aktif'] ?? '') === '1')>Aktif</option>
                    <option value="0" @selected(($filters['aktif'] ?? '') === '0')>Nonaktif</option>
                </select>
                <label class="sr-only" for="tahun">Tahun daftar</label>
                <select id="tahun" name="tahun" class="{{ $field }} cursor-pointer px-4" onchange="this.form.submit()">
                    <option value="">Semua tahun</option>
                    @foreach ($years as $y)
                        <option value="{{ $y }}" @selected(($filters['tahun'] ?? '') == $y)>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex shrink-0 gap-2 lg:ml-auto">
                <button type="submit" class="{{ $btn }} bg-pema-500 text-white shadow-md shadow-pema-500/25 hover:bg-pema-600">
                    <i class="fi fi-rs-search"></i> Cari
                </button>
                @if (array_filter($filters, fn ($v) => $v !== null && $v !== ''))
                    <a href="{{ route('ppid.akun.index') }}" class="{{ $btn }} border border-gray-200 bg-white text-gray-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                        <i class="fi fi-rs-rotate-left"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        @if ($items->isEmpty())
            <p class="px-6 py-16 text-center text-sm text-gray-500">Tidak ada akun yang cocok.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="border-b border-gray-200">
                        <tr class="text-xs font-medium text-gray-500">
                            <th scope="col" class="px-5 py-3 font-medium">Nama</th>
                            <th scope="col" class="px-5 py-3 font-medium">Kontak</th>
                            <th scope="col" class="px-5 py-3 font-medium">Kategori</th>
                            <th scope="col" class="px-5 py-3 font-medium text-right">Permohonan</th>
                            <th scope="col" class="px-5 py-3 font-medium text-right">Keberatan</th>
                            <th scope="col" class="px-5 py-3 font-medium">Terdaftar</th>
                            <th scope="col" class="px-5 py-3 font-medium">Status</th>
                            <th scope="col" class="px-5 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($items as $u)
                            <tr class="align-top hover:bg-gray-50">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-pema-100 text-pema-700 flex items-center justify-center flex-shrink-0 font-semibold text-xs">{{ strtoupper(mb_substr($u->name, 0, 1)) }}</div>
                                        <span class="text-sm font-medium text-gray-800">{{ $u->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm text-gray-700">{{ $u->email }}</p>
                                    <p class="text-xs text-gray-500 tabular-nums">{{ $u->telepon ?: '—' }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">{{ $u->kategori?->kategori_pemohon ?? '—' }}</td>
                                <td class="px-5 py-4 text-right text-sm tabular-nums text-gray-700">{{ $u->permohonan_count }}</td>
                                <td class="px-5 py-4 text-right text-sm tabular-nums text-gray-700">{{ $u->keberatan_count }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 tabular-nums">{{ $u->created_at?->format('d/m/Y') }}</td>
                                <td class="px-5 py-4">@include('ppid.partials.status-badge', ['label' => $u->active ? 'Aktif' : 'Nonaktif', 'color' => $u->active ? 'success' : 'gray'])</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <a href="{{ route('ppid.pengguna.show', $u->id) }}" class="text-sm font-medium text-pema-500 hover:text-pema-600">Lihat<span class="sr-only"> {{ $u->name }}</span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-gray-200 px-5 py-4">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
