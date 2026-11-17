@extends('admin.layouts.master')

@section('title', 'Semua Data Masuk')
@section('page_title', 'Semua Data Masuk')

@php
    $fmt = fn ($n) => number_format((int) $n, 0, ',', '.');
    $field = 'h-11 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 shadow-sm transition-all duration-200 hover:border-pema-300 focus:border-pema-400 focus:outline-none focus:ring-4 focus:ring-pema-500/15';
    $btn = 'inline-flex h-11 items-center justify-center gap-2 whitespace-nowrap rounded-xl px-4 text-sm font-medium transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 active:scale-95';
    $jenis = $filters['jenis'] ?? '';
    $base = array_diff_key($filters, ['jenis' => true]);
    $hasFilter = array_filter($filters, fn ($v) => $v !== null && $v !== '');
    $tab = 'group inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200 active:scale-95';
    $on = 'bg-pema-500 text-white shadow-md shadow-pema-500/25';
    $off = 'text-gray-600 hover:bg-pema-50 hover:text-pema-600';
    $dot = ['pemohon' => 'bg-pema-100 text-pema-600', 'keberatan' => 'bg-purple-100 text-purple-700'];
@endphp

@section('content')
<div class="p-6 space-y-6">
    <a href="{{ route('ppid.dashboard') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-gray-800">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 12.5 5.5 8 10 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Kembali ke Dashboard PPID
    </a>

    <div>
        <h1 class="font-heading text-xl font-semibold text-gray-900">Semua Data Masuk</h1>
        <p class="text-sm text-gray-500 mt-0.5">Seluruh permohonan informasi dan keberatan dari portal PPID, terbaru di atas</p>
    </div>

    <nav aria-label="Saring jenis" class="flex flex-wrap gap-1.5 rounded-2xl border border-gray-100 bg-white p-1.5 shadow-sm">
        @foreach (['' => ['Semua', 'all'], 'pemohon' => ['Permohonan', 'pemohon'], 'keberatan' => ['Keberatan', 'keberatan']] as $key => [$label, $count])
            @php $active = $jenis === $key; @endphp
            <a href="{{ route('ppid.masuk.index', $key ? $base + ['jenis' => $key] : $base) }}" class="{{ $tab }} {{ $active ? $on : $off }}" @if ($active) aria-current="page" @endif>
                {{ $label }}
                <span class="rounded-full px-2 py-0.5 text-xs font-semibold tabular-nums {{ $active ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }}">{{ $fmt($counts[$count]) }}</span>
            </a>
        @endforeach
    </nav>

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        <form method="GET" action="{{ route('ppid.masuk.index') }}" class="flex flex-col gap-3 border-b border-gray-100 p-4 sm:p-5 lg:flex-row lg:items-center">
            @if ($jenis)
                <input type="hidden" name="jenis" value="{{ $jenis }}">
            @endif
            <div class="relative min-w-0 flex-1">
                <label class="sr-only" for="q">Cari</label>
                <i class="fi fi-rs-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input id="q" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama, email, atau no. permohonan" autocomplete="off"
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
                    <a href="{{ route('ppid.masuk.index') }}" class="{{ $btn }} border border-gray-200 bg-white text-gray-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                        <i class="fi fi-rs-rotate-left"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        @if ($items->isEmpty())
            <p class="px-6 py-16 text-center text-sm text-gray-500">
                {{ $hasFilter ? 'Tidak ada data yang cocok dengan filter ini.' : 'Belum ada permohonan atau keberatan.' }}
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="border-b border-gray-200">
                        <tr class="text-xs font-medium text-gray-500">
                            <th scope="col" class="px-5 py-3 font-medium">Pemohon</th>
                            <th scope="col" class="px-5 py-3 font-medium">Jenis</th>
                            <th scope="col" class="px-5 py-3 font-medium">No. permohonan</th>
                            <th scope="col" class="px-5 py-3 font-medium">Isi</th>
                            <th scope="col" class="px-5 py-3 font-medium">Masuk</th>
                            <th scope="col" class="px-5 py-3 font-medium">Status</th>
                            <th scope="col" class="px-5 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($items as $row)
                            <tr class="align-top hover:bg-gray-50">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full {{ $dot[$row['key']] }} flex items-center justify-center flex-shrink-0 font-semibold text-xs">{{ strtoupper(mb_substr($row['nama'], 0, 1)) }}</div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-800">{{ $row['nama'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $row['email'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    @include('ppid.partials.status-badge', ['label' => $row['type'], 'color' => $row['key'] === 'pemohon' ? 'brand' : 'gray'])
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-800 tabular-nums">{{ $row['nomor'] }}</td>
                                <td class="max-w-xs px-5 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($row['detail'], 80) }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 tabular-nums">
                                    {{ $row['date']->format('d/m/Y H:i') }}
                                    <p class="text-xs text-gray-400">{{ $row['date']->diffForHumans() }}</p>
                                </td>
                                <td class="px-5 py-4">@include('ppid.partials.status-badge', ['label' => $row['status'], 'color' => $row['color']])</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <a href="{{ $row['url'] }}" class="text-sm font-medium text-pema-500 hover:text-pema-600">Lihat<span class="sr-only"> {{ $row['nomor'] }}</span></a>
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
