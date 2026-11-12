@extends('admin.layouts.master')

@section('title', 'Pemohon Informasi')
@section('page_title', 'Pemohon Informasi')

@php
    $fmt = fn ($n) => number_format((int) $n, 0, ',', '.');
    $field = 'h-11 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 shadow-sm transition-all duration-200 hover:border-pema-300 focus:border-pema-400 focus:outline-none focus:ring-4 focus:ring-pema-500/15';
    $btn = 'inline-flex h-11 items-center justify-center gap-2 whitespace-nowrap rounded-xl px-4 text-sm font-medium transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 active:scale-95';
    $hasFilter = array_filter($filters, fn ($v) => $v !== null && $v !== '');
@endphp

@section('content')
<div class="p-6 space-y-6">
    <div>
        <h1 class="font-heading text-xl font-semibold text-gray-900">Daftar Pemohon Informasi</h1>
        <p class="text-sm text-gray-500 mt-0.5">Pemohon yang mengajukan permohonan informasi melalui portal PPID</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        @foreach ([
            ['label' => 'Total permohonan', 'value' => $total,       'icon' => 'fi fi-rs-document',     'bg' => 'bg-pema-50',  'fg' => 'text-pema-500'],
            ['label' => 'Pemohon unik',     'value' => $pemohonUnik, 'icon' => 'fi fi-rs-users',        'bg' => 'bg-amber-50', 'fg' => 'text-amber-600'],
            ['label' => 'Sudah selesai',    'value' => $selesai,     'icon' => 'fi fi-rs-check-circle', 'bg' => 'bg-green-50', 'fg' => 'text-green-600'],
        ] as $t)
            <div class="flex items-center gap-3 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg {{ $t['bg'] }}"><i class="{{ $t['icon'] }} {{ $t['fg'] }}"></i></div>
                <div>
                    <p class="text-xs text-gray-400">{{ $t['label'] }}{{ $hasFilter ? ' (sesuai filter)' : '' }}</p>
                    <p class="font-heading text-lg font-semibold text-gray-900 tabular-nums">{{ $fmt($t['value']) }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <form method="GET" action="{{ route('ppid.pengguna.index') }}" class="flex flex-col gap-3 border-b border-gray-100 p-4 sm:p-5 lg:flex-row lg:items-center">
            <div class="relative min-w-0 flex-1">
                <label class="sr-only" for="q">Cari</label>
                <i class="fi fi-rs-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input id="q" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama, email, no. KTP, atau no. permohonan" autocomplete="off"
                       class="{{ $field }} w-full pl-11 pr-4 placeholder:text-gray-400">
            </div>
            <div class="flex flex-wrap gap-3">
                <label class="sr-only" for="status">Status</label>
                <select id="status" name="status" class="{{ $field }} cursor-pointer px-4" onchange="this.form.submit()">
                    <option value="">Semua status</option>
                    @foreach ($statuses as $key => $def)
                        <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>{{ $def['label'] }}</option>
                    @endforeach
                </select>
                <label class="sr-only" for="kategori">Kategori</label>
                <select id="kategori" name="kategori" class="{{ $field }} cursor-pointer px-4" onchange="this.form.submit()">
                    <option value="">Semua kategori</option>
                    @foreach ($kategori as $id => $label)
                        <option value="{{ $id }}" @selected(($filters['kategori'] ?? '') == $id)>{{ $label }}</option>
                    @endforeach
                </select>
                <label class="sr-only" for="tahun">Tahun</label>
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
                @if ($hasFilter)
                    <a href="{{ route('ppid.pengguna.index') }}" class="{{ $btn }} border border-gray-200 bg-white text-gray-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                        <i class="fi fi-rs-rotate-left"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        @if ($items->isEmpty())
            <p class="px-6 py-16 text-center text-sm text-gray-500">
                {{ $hasFilter ? 'Tidak ada pemohon yang cocok dengan filter ini.' : 'Belum ada permohonan informasi.' }}
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="border-b border-gray-200">
                        <tr class="text-xs font-medium text-gray-500">
                            <th scope="col" class="px-5 py-3 font-medium">Pemohon</th>
                            <th scope="col" class="px-5 py-3 font-medium">Kontak</th>
                            <th scope="col" class="px-5 py-3 font-medium">Kategori</th>
                            <th scope="col" class="px-5 py-3 font-medium">No. permohonan</th>
                            <th scope="col" class="px-5 py-3 font-medium">Informasi yang diminta</th>
                            <th scope="col" class="px-5 py-3 font-medium">Tanggal</th>
                            <th scope="col" class="px-5 py-3 font-medium">Status</th>
                            <th scope="col" class="px-5 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($items as $p)
                            <tr class="align-top hover:bg-gray-50">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-pema-100 text-pema-700 flex items-center justify-center flex-shrink-0 font-semibold text-xs">{{ strtoupper(mb_substr($p->nama, 0, 1)) }}</div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-800">{{ $p->nama }}</p>
                                            <p class="text-xs text-gray-500 tabular-nums">{{ $p->user?->no_ktp ? 'KTP ' . $p->user->no_ktp : '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm text-gray-700">{{ $p->email ?: '—' }}</p>
                                    <p class="text-xs text-gray-500 tabular-nums">{{ $p->telepon ?: '—' }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">{{ $p->user?->kategori?->kategori_pemohon ?? '—' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-800 tabular-nums">{{ $p->no_permohonan }}</td>
                                <td class="max-w-xs px-5 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($p->rincian_informasi, 80) }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 tabular-nums">{{ $p->created_at->format('d/m/Y') }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-col items-start gap-1">
                                        @include('ppid.partials.status-badge', ['label' => $p->status_label, 'color' => $p->status_color])
                                        @if ($p->terlambat)
                                            @include('ppid.partials.status-badge', ['label' => 'Lewat batas waktu', 'color' => 'error'])
                                        @endif
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <a href="{{ route('ppid.pemohon.show', $p->id) }}" class="text-sm font-medium text-pema-500 hover:text-pema-600">Lihat<span class="sr-only"> {{ $p->no_permohonan }}</span></a>
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
