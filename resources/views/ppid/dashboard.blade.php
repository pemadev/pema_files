@extends('admin.layouts.master')

@section('title', 'Dashboard PPID')
@section('page_title', 'Dashboard PPID')

@php
    $fmt = fn ($n) => number_format((int) $n, 0, ',', '.');
    $hex = ['success' => '#16a34a', 'warning' => '#d97706', 'error' => '#dc2626', 'brand' => '#0A6AC9', 'gray' => '#9ca3af'];
    $statusChart = [];
    foreach (array_keys($statusDefs) as $k) {
        $statusChart[$k] = [
            'labels' => array_values(array_map(fn ($d) => $d['label'], $statusDefs[$k])),
            'data'   => array_values(array_map(fn ($sKey) => $status[$k][$sKey] ?? 0, array_keys($statusDefs[$k]))),
            'colors' => array_values(array_map(fn ($d) => $hex[$d['color']] ?? '#9ca3af', $statusDefs[$k])),
        ];
    }
    $cardStyle = [
        'pemohon'   => ['bg' => 'bg-pema-50',   'fg' => 'text-pema-500',   'icon' => 'fi fi-rs-users'],
        'pengaduan' => ['bg' => 'bg-amber-50',  'fg' => 'text-amber-600',  'icon' => 'fi fi-rs-megaphone'],
        'keberatan' => ['bg' => 'bg-purple-50', 'fg' => 'text-purple-600', 'icon' => 'fi fi-rs-scale'],
    ];
    $kpMax = max(1, max(array_column($kategoriPemohon, 'total') ?: [0]));
    $csMax = max(1, max(array_column($caraSalinan, 'total') ?: [0]));
    $diproses = $status['pemohon']['disubmit'] ?? 0;
    $kbrProses = $status['keberatan']['disubmit'] ?? 0;
@endphp

@section('content')
<div class="p-6 space-y-6">

    {{-- ================= JUDUL + TAHUN ================= --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-heading text-xl font-semibold text-gray-900">Dashboard PPID</h1>
            <p class="text-sm text-gray-500 mt-0.5">Rekap layanan informasi publik PT PEMA tahun {{ $year }}</p>
        </div>
        <form method="GET" action="{{ route('ppid.dashboard') }}" class="flex items-center gap-2">
            <label for="tahun" class="text-sm text-gray-500">Tahun</label>
            <select id="tahun" name="tahun" onchange="this.form.submit()"
                    class="h-10 rounded-xl border border-gray-200 bg-white px-3 text-sm text-gray-800 shadow-sm focus:border-pema-400 focus:outline-none focus:ring-2 focus:ring-pema-500/20">
                @foreach ($years as $y)
                    <option value="{{ $y }}" @selected($y === $year)>{{ $y }}</option>
                @endforeach
            </select>
            <noscript><button type="submit" class="h-10 rounded-xl bg-pema-500 px-4 text-sm font-medium text-white">Tampilkan</button></noscript>
        </form>
    </div>

    {{-- ================= TOMBOL CEPAT ================= --}}
    <div class="bg-gray-200 rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="ppid-qa-grid">
            <a href="{{ route('ppid.pemohon.index', ['tahun' => $year]) }}" class="qa-btn qa-blue">
                <span class="qa-count">{{ $fmt($cards[0]['total']) }}</span>
                <div class="qa-ico"><i class="fi fi-rs-users text-lg"></i></div>
                <span class="qa-lbl">Jumlah Pemohon</span>
            </a>
            <a href="{{ route('ppid.pemohon.index', ['status' => 'disubmit']) }}" class="qa-btn qa-amber">
                <span class="qa-count">{{ $fmt($diproses) }}</span>
                <div class="qa-ico"><i class="fi fi-rs-hourglass-end text-lg"></i></div>
                <span class="qa-lbl">Permohonan Baru</span>
            </a>
            <a href="{{ route('ppid.pengguna.index') }}" class="qa-btn qa-rose">
                @if ($akun['total'])<span class="qa-count">{{ $fmt($akun['total']) }}</span>@endif
                <div class="qa-ico"><i class="fi fi-rs-id-badge text-lg"></i></div>
                <span class="qa-lbl">Pemohon Informasi</span>
            </a>
            <a href="{{ route('ppid.keberatan.index', ['status' => 'disubmit']) }}" class="qa-btn qa-purple">
                <span class="qa-count">{{ $fmt($kbrProses) }}</span>
                <div class="qa-ico"><i class="fi fi-rs-scale text-lg"></i></div>
                <span class="qa-lbl">Keberatan Baru</span>
            </a>
            <a href="{{ route('ppid.pemohon.index', ['status' => 'diproses']) }}" class="qa-btn qa-slate">
                <span class="qa-count {{ $terlambat > 0 ? 'qa-count-alert' : '' }}">{{ $fmt($terlambat) }}</span>
                <div class="qa-ico"><i class="fi fi-rs-alarm-clock text-lg"></i></div>
                <span class="qa-lbl">Lewat Batas Waktu</span>
            </a>
            <a href="{{ route('ppid.pemohon.export', ['tahun' => $year]) }}" class="qa-btn qa-green">
                <div class="qa-ico"><i class="fi fi-rs-download text-lg"></i></div>
                <span class="qa-lbl">Ekspor Data</span>
            </a>
        </div>
    </div>

    @if ($terlambat > 0)
        <a href="{{ route('ppid.pemohon.index', ['status' => 'diproses']) }}"
           class="flex flex-wrap items-center justify-between gap-2 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 hover:bg-red-100 transition-colors">
            <span class="flex items-center gap-3">
                <i class="fi fi-rs-exclamation text-red-500"></i>
                <span><strong class="font-semibold">{{ $fmt($terlambat) }} permohonan</strong> sudah melewati batas jawaban 10 hari kerja dan masih diproses.</span>
            </span>
            <span class="font-medium underline underline-offset-2">Tinjau sekarang</span>
        </a>
    @endif

    {{-- ================= KARTU RINGKASAN ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach ($cards as $card)
            @php $st = $cardStyle[$card['key']]; @endphp
            <a href="{{ $card['route'] }}" class="ppid-stat group bg-white rounded-2xl border border-gray-100 shadow-sm p-5 block">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 {{ $st['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="{{ $st['icon'] }} {{ $st['fg'] }} text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400">{{ $card['label'] }} {{ $year }}</p>
                        <p class="text-lg font-heading font-semibold text-gray-900 tabular-nums" data-countup="{{ (int) $card['total'] }}">{{ $fmt($card['total']) }}</p>
                    </div>
                    <i class="fi fi-rs-angle-small-right ml-auto text-gray-300 transition-transform group-hover:translate-x-1 group-hover:text-pema-500"></i>
                </div>
                <div class="mt-3 flex flex-wrap items-center justify-between gap-2 text-xs">
                    @if (!is_null($card['growth']))
                        <span class="{{ $card['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $card['growth'] >= 0 ? '▲' : '▼' }} {{ abs($card['growth']) }}% vs bulan lalu
                        </span>
                    @else
                        <span class="text-gray-400">Bulan ini: {{ $fmt($card['monthNow']) }}</span>
                    @endif
                    <span class="{{ $card['pending'] > 0 ? 'text-amber-600' : 'text-green-600' }} font-medium">
                        {{ $card['pending'] > 0 ? $fmt($card['pending']) . ' ' . $card['pendingLabel'] : 'Semua tertangani' }}
                    </span>
                </div>
            </a>
        @endforeach
    </div>

    {{-- ================= MENU GRAFIK ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-4 py-3 flex items-center justify-between gap-3 flex-wrap">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                <i class="fi fi-rs-chart-line-up text-pema-500 text-sm"></i>
            </div>
            <h2 class="font-heading font-semibold text-gray-900 text-sm">Menu Grafik</h2>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <div class="flex items-center gap-2 flex-wrap" role="group" aria-label="Pilih data grafik">
                <button type="button" data-ppid-tab="all" class="chart-tab chart-tab-active" aria-pressed="true">Semua</button>
                <button type="button" data-ppid-tab="pemohon" class="chart-tab" aria-pressed="false">Permohonan</button>
                <button type="button" data-ppid-tab="keberatan" class="chart-tab" aria-pressed="false">Keberatan</button>
            </div>
            <span class="hidden sm:block w-px h-6 bg-gray-200"></span>
            <div class="flex items-center gap-2" role="group" aria-label="Jenis grafik">
                <button type="button" data-ppid-type="bar" class="chart-tab chart-tab-active" aria-pressed="true" title="Grafik batang"><i class="fi fi-rs-chart-histogram"></i></button>
                <button type="button" data-ppid-type="line" class="chart-tab" aria-pressed="false" title="Grafik garis"><i class="fi fi-rs-chart-line-up"></i></button>
            </div>
        </div>
    </div>

    {{-- ================= GRAFIK ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-3">
                <div>
                    <h3 class="font-heading font-semibold text-gray-900 text-sm">Layanan Masuk per Bulan</h3>
                    <p class="text-xs text-gray-400 mt-0.5" id="ppidChartSub">Permohonan dan keberatan tahun {{ $year }}</p>
                </div>
                <span class="text-xs text-gray-400">Total <strong class="text-gray-900" id="ppidChartTotal">{{ $fmt(array_sum(array_column($cards, 'total'))) }}</strong></span>
            </div>
            <div class="p-5">
                <div class="relative h-72">
                    <canvas id="ppidMonthlyChart" role="img" aria-label="Grafik jumlah layanan PPID per bulan tahun {{ $year }}"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Status Penanganan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Klik tab untuk mengganti jenis layanan</p>
            </div>
            <div class="p-5 space-y-4">
                <div class="flex gap-1 rounded-xl bg-gray-100 p-1" role="group" aria-label="Pilih jenis layanan">
                    <button type="button" data-status-tab="pemohon" class="status-tab status-tab-active flex-1" aria-pressed="true">Permohonan</button>
                    <button type="button" data-status-tab="keberatan" class="status-tab flex-1" aria-pressed="false">Keberatan</button>
                </div>
                <div class="relative h-48">
                    <canvas id="ppidStatusChart" role="img" aria-label="Diagram status penanganan"></canvas>
                    <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                        <span class="font-heading text-2xl font-semibold text-gray-900" id="ppidStatusTotal">0</span>
                        <span class="text-xs text-gray-400">total</span>
                    </div>
                </div>
                <ul id="ppidStatusLegend" class="space-y-2"></ul>
            </div>
        </div>
    </div>

    {{-- ================= REKAP BULANAN MASUK & KELUAR ================= --}}
    @php
        $jenisLabel = ['pemohon' => 'Permohonan', 'keberatan' => 'Keberatan'];
        $dotBg = ['success' => 'bg-green-500', 'warning' => 'bg-amber-500', 'error' => 'bg-red-500', 'brand' => 'bg-pema-500', 'gray' => 'bg-gray-400'];
        $numTxt = ['success' => 'text-green-700', 'warning' => 'text-amber-700', 'error' => 'text-red-700', 'brand' => 'text-pema-700', 'gray' => 'text-gray-700'];
        $nowMonth = $year === (int) now()->format('Y') ? (int) now()->format('n') : 13;
    @endphp
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm" x-data="{ jenis: 'pemohon' }">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center"><i class="fi fi-rs-table-list text-pema-500 text-sm"></i></div>
                <div>
                    <h3 class="font-heading font-semibold text-gray-900 text-sm">Rekap Bulanan Data Masuk &amp; Keluar</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Masuk = tanggal diterima · Keluar = tanggal selesai, per status · tahun {{ $year }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex items-center gap-2 flex-wrap" role="group" aria-label="Pilih jenis layanan">
                    @foreach ($jenisLabel as $jk => $jl)
                        <button type="button" @click="jenis = '{{ $jk }}'" :class="jenis === '{{ $jk }}' ? 'chart-tab chart-tab-active' : 'chart-tab'" :aria-pressed="jenis === '{{ $jk }}'">{{ $jl }}</button>
                    @endforeach
                </div>
                <span class="hidden sm:block w-px h-6 bg-gray-200"></span>
                <button type="button" class="chart-tab" @click="window.ppidRekapCsv(jenis)" title="Unduh rekap sebagai CSV">
                    <i class="fi fi-rs-download"></i> Unduh CSV
                </button>
            </div>
        </div>

        @foreach ($jenisLabel as $jk => $jl)
            @php $rk = $rekap[$jk]; $cols = count($rk['final']); @endphp
            <div x-show="jenis === '{{ $jk }}'" @if ($jk !== 'pemohon') x-cloak @endif>
                {{-- Ringkasan --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 p-5 pb-0">
                    <div class="rounded-xl bg-pema-50 px-4 py-3">
                        <p class="text-xs text-pema-700">Total masuk</p>
                        <p class="font-heading text-xl font-semibold text-gray-900 tabular-nums">{{ $fmt($rk['total']['masuk']) }}</p>
                    </div>
                    <div class="rounded-xl bg-green-50 px-4 py-3">
                        <p class="text-xs text-green-700">Total keluar (selesai)</p>
                        <p class="font-heading text-xl font-semibold text-gray-900 tabular-nums">{{ $fmt($rk['total']['total_keluar']) }}</p>
                    </div>
                    <div class="rounded-xl bg-amber-50 px-4 py-3">
                        <p class="text-xs text-amber-700">Belum selesai</p>
                        <p class="font-heading text-xl font-semibold text-gray-900 tabular-nums">{{ $fmt($rk['total']['belum']) }}</p>
                    </div>
                    <div class="rounded-xl bg-gray-50 px-4 py-3">
                        <p class="text-xs text-gray-500">Tingkat penyelesaian</p>
                        <p class="font-heading text-xl font-semibold text-gray-900 tabular-nums">{{ $rk['total']['masuk'] ? round(($rk['total']['masuk'] - $rk['total']['belum']) / $rk['total']['masuk'] * 100) : 0 }}%</p>
                    </div>
                </div>

                <div class="p-5 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-xs text-gray-500">
                                <th scope="col" rowspan="2" class="px-3 py-2 text-left font-medium border-b border-gray-200">Bulan</th>
                                <th scope="col" rowspan="2" class="px-3 py-2 text-right font-medium border-b border-gray-200 bg-pema-50/60 text-pema-700">Masuk</th>
                                <th scope="colgroup" colspan="{{ $cols + 1 }}" class="px-3 py-2 text-center font-medium bg-green-50/60 text-green-700">Keluar (selesai) per status</th>
                                <th scope="col" rowspan="2" class="px-3 py-2 text-right font-medium border-b border-gray-200 bg-amber-50/60 text-amber-700">Belum selesai</th>
                                <th scope="col" rowspan="2" class="px-3 py-2 text-left font-medium border-b border-gray-200 min-w-[140px]">Penyelesaian</th>
                            </tr>
                            <tr class="text-xs text-gray-500">
                                @foreach ($rk['final'] as $f)
                                    <th scope="col" class="px-3 py-2 text-right font-medium border-b border-gray-200 bg-green-50/30 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5"><span class="w-2 h-2 rounded-full {{ $dotBg[$f['color']] ?? 'bg-gray-400' }}"></span>{{ $f['label'] }}</span>
                                    </th>
                                @endforeach
                                <th scope="col" class="px-3 py-2 text-right font-semibold border-b border-gray-200 bg-green-50/60 text-green-700">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($rk['rows'] as $r)
                                @php
                                    $future = $r['m'] > $nowMonth;
                                    $isNow = $r['m'] === $nowMonth;
                                    $pct = $r['masuk'] ? round(($r['masuk'] - $r['belum']) / $r['masuk'] * 100) : null;
                                @endphp
                                <tr class="transition-colors hover:bg-gray-50 {{ $isNow ? 'bg-pema-50/40' : '' }} {{ $future ? 'text-gray-300' : 'text-gray-700' }}">
                                    <td class="px-3 py-2.5 whitespace-nowrap font-medium {{ $future ? '' : 'text-gray-900' }}">
                                        {{ $r['bulan'] }}
                                        @if ($isNow)<span class="ml-1.5 rounded-full bg-pema-500 px-1.5 py-0.5 text-[10px] font-semibold text-white align-middle">Bulan ini</span>@endif
                                    </td>
                                    <td class="px-3 py-2.5 text-right tabular-nums font-semibold bg-pema-50/30 {{ $r['masuk'] ? 'text-pema-700' : '' }}">{{ $r['masuk'] ?: '–' }}</td>
                                    @foreach ($rk['final'] as $f)
                                        @php $v = $r['keluar'][$f['key']]; @endphp
                                        <td class="px-3 py-2.5 text-right tabular-nums {{ $v ? ($numTxt[$f['color']] ?? '') : '' }}">{{ $v ?: '–' }}</td>
                                    @endforeach
                                    <td class="px-3 py-2.5 text-right tabular-nums font-semibold bg-green-50/30 {{ $r['total_keluar'] ? 'text-green-700' : '' }}">{{ $r['total_keluar'] ?: '–' }}</td>
                                    <td class="px-3 py-2.5 text-right tabular-nums {{ $r['belum'] ? 'font-semibold text-amber-700 bg-amber-50/40' : '' }}">{{ $r['belum'] ?: '–' }}</td>
                                    <td class="px-3 py-2.5">
                                        @if (!is_null($pct))
                                            <div class="flex items-center gap-2">
                                                <div class="h-1.5 flex-1 rounded-full bg-gray-100 overflow-hidden">
                                                    <div class="ppid-bar h-full rounded-full {{ $pct === 100 ? 'bg-green-500' : 'bg-pema-500' }}" style="--w: {{ $pct }}%"></div>
                                                </div>
                                                <span class="w-9 text-right text-xs tabular-nums text-gray-500">{{ $pct }}%</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-200 font-semibold text-gray-900">
                                <th scope="row" class="px-3 py-3 text-left">Total {{ $year }}</th>
                                <td class="px-3 py-3 text-right tabular-nums bg-pema-50/60 text-pema-700">{{ $fmt($rk['total']['masuk']) }}</td>
                                @foreach ($rk['final'] as $f)
                                    <td class="px-3 py-3 text-right tabular-nums {{ $numTxt[$f['color']] ?? '' }}">{{ $fmt($rk['total']['keluar'][$f['key']]) }}</td>
                                @endforeach
                                <td class="px-3 py-3 text-right tabular-nums bg-green-50/60 text-green-700">{{ $fmt($rk['total']['total_keluar']) }}</td>
                                <td class="px-3 py-3 text-right tabular-nums bg-amber-50/60 text-amber-700">{{ $fmt($rk['total']['belum']) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <p class="mt-3 text-xs text-gray-400">“Belum selesai” dihitung dari data yang masuk pada bulan tersebut dan statusnya belum final. “Keluar” dihitung pada bulan permohonan diselesaikan, sehingga bisa berbeda bulan dengan tanggal masuk.</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ================= KATEGORI ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center"><i class="fi fi-rs-users text-pema-500 text-sm"></i></div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Kategori Pemohon</h3>
            </div>
            <div class="p-5 space-y-4">
                @foreach ($kategoriPemohon as $k)
                    <div>
                        <div class="flex justify-between text-sm mb-1.5"><span class="text-gray-700">{{ $k['label'] }}</span><span class="font-semibold text-gray-900 tabular-nums">{{ $fmt($k['total']) }}</span></div>
                        <div class="h-2 rounded-full bg-gray-100 overflow-hidden"><div class="ppid-bar h-full rounded-full bg-pema-500" style="--w: {{ round($k['total'] / $kpMax * 100, 1) }}%"></div></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center"><i class="fi fi-rs-envelope text-amber-600 text-sm"></i></div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Cara Mendapatkan Salinan</h3>
            </div>
            <div class="p-5 space-y-4">
                @forelse ($caraSalinan as $k)
                    <div>
                        <div class="flex justify-between text-sm mb-1.5"><span class="text-gray-700">{{ $k['label'] }}</span><span class="font-semibold text-gray-900 tabular-nums">{{ $fmt($k['total']) }}</span></div>
                        <div class="h-2 rounded-full bg-gray-100 overflow-hidden"><div class="ppid-bar h-full rounded-full bg-amber-500" style="--w: {{ round($k['total'] / $csMax * 100, 1) }}%"></div></div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center">Belum ada permohonan tahun {{ $year }}.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ================= AKUN PENGGUNA (API) ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center"><i class="fi fi-rs-user-add text-pema-500 text-sm"></i></div>
                <div>
                    <h3 class="font-heading font-semibold text-gray-900 text-sm">Akun Pengguna Terdaftar</h3>
                    <p class="text-xs text-gray-400">Akun pemohon di portal PPID</p>
                </div>
            </div>
            @if ($akun['fetchedAt'])
                <span class="text-xs text-gray-400">Diperbarui {{ $akun['fetchedAt']->timezone(config('app.timezone'))->diffForHumans() }}</span>
            @endif
        </div>

        @if (! $akun['configured'])
            <p class="p-5 text-sm text-gray-400 text-center">API akun pengguna belum dikonfigurasi. Isi <code class="text-gray-600">PPID_API_USERS_URL</code> di file <code class="text-gray-600">.env</code>.</p>
        @elseif ($akun['error'])
            <p class="p-5 text-sm text-red-600 text-center">{{ $akun['error'] }}</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-5 border-b border-gray-100">
                <div class="rounded-xl bg-pema-50 p-4">
                    <p class="text-xs text-pema-700">Total akun</p>
                    <p class="text-lg font-heading font-semibold text-gray-900 tabular-nums" data-countup="{{ (int) $akun['total'] }}">{{ $fmt($akun['total']) }}</p>
                </div>
                <div class="rounded-xl bg-green-50 p-4">
                    <p class="text-xs text-green-700">Akun aktif</p>
                    <p class="text-lg font-heading font-semibold text-gray-900 tabular-nums" data-countup="{{ (int) $akun['aktif'] }}">{{ $fmt($akun['aktif']) }}</p>
                </div>
                <div class="rounded-xl bg-gray-50 p-4">
                    <p class="text-xs text-gray-500">Daftar bulan ini</p>
                    <p class="text-lg font-heading font-semibold text-gray-900 tabular-nums" data-countup="{{ (int) $akun['bulanIni'] }}">{{ $fmt($akun['bulanIni']) }}</p>
                </div>
            </div>

            @if (empty($akun['terbaru']))
                <p class="p-5 text-sm text-gray-400 text-center">Belum ada akun terdaftar.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                                <th class="px-5 py-3 font-medium">Nama</th>
                                <th class="px-5 py-3 font-medium">Email</th>
                                <th class="px-5 py-3 font-medium">Telepon</th>
                                <th class="px-5 py-3 font-medium">Terdaftar</th>
                                <th class="px-5 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($akun['terbaru'] as $u)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-pema-100 text-pema-700 flex items-center justify-center flex-shrink-0 font-semibold text-xs">{{ strtoupper(mb_substr($u['name'], 0, 1)) }}</div>
                                            <span class="font-medium text-gray-900">{{ $u['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-gray-600">{{ $u['email'] }}</td>
                                    <td class="px-5 py-3 text-gray-600 tabular-nums">{{ $u['telepon'] ?: '-' }}</td>
                                    <td class="px-5 py-3 text-gray-500 whitespace-nowrap">{{ $u['created'] ? $u['created']->translatedFormat('d M Y, H:i') : '-' }}</td>
                                    <td class="px-5 py-3">
                                        @include('ppid.partials.status-badge', ['label' => $u['active'] ? 'Aktif' : 'Nonaktif', 'color' => $u['active'] ? 'success' : 'gray'])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>

    {{-- ================= MASUK TERBARU ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm" x-data="{ filter: 'all' }">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center"><i class="fi fi-rs-clock text-pema-500 text-sm"></i></div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Masuk Terbaru</h3>
            </div>
            <div class="flex items-center gap-2 flex-wrap" role="group" aria-label="Saring jenis">
                <button type="button" @click="filter = 'all'" :class="filter === 'all' ? 'chart-tab chart-tab-active' : 'chart-tab'" :aria-pressed="filter === 'all'">Semua</button>
                <button type="button" @click="filter = 'pemohon'" :class="filter === 'pemohon' ? 'chart-tab chart-tab-active' : 'chart-tab'" :aria-pressed="filter === 'pemohon'">Permohonan</button>
                <button type="button" @click="filter = 'keberatan'" :class="filter === 'keberatan' ? 'chart-tab chart-tab-active' : 'chart-tab'" :aria-pressed="filter === 'keberatan'">Keberatan</button>
            </div>
        </div>
        <div class="p-5">
            @if ($recent->isEmpty())
                <p class="text-sm text-gray-400 text-center py-4">Belum ada permohonan atau keberatan.</p>
            @else
                <div class="space-y-3">
                    @foreach ($recent as $row)
                        @php
                            $dot = ['pemohon' => 'bg-pema-100 text-pema-600', 'pengaduan' => 'bg-amber-100 text-amber-700', 'keberatan' => 'bg-purple-100 text-purple-700'][$row['key']];
                        @endphp
                        <a href="{{ $row['url'] }}" x-show="filter === 'all' || filter === '{{ $row['key'] }}'"
                           class="flex items-center gap-3 rounded-xl p-2 -mx-2 hover:bg-gray-50 transition-colors">
                            <div class="w-9 h-9 rounded-full {{ $dot }} flex items-center justify-center flex-shrink-0 font-semibold text-xs">{{ strtoupper(substr($row['nama'], 0, 1)) }}</div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm text-gray-700 truncate"><span class="font-medium text-gray-900">{{ $row['nama'] }}</span> mengajukan {{ strtolower($row['type']) }}</p>
                                <p class="text-xs text-gray-400">{{ $row['nomor'] }} · {{ $row['date']->diffForHumans() }}</p>
                            </div>
                            @include('ppid.partials.status-badge', ['label' => $row['status'], 'color' => $row['color']])
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.ppid-qa-grid { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 12px; }
@media (max-width: 1023px) { .ppid-qa-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
@media (max-width: 539px)  { .ppid-qa-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
.qa-btn { position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 16px 8px; border-radius: 12px; border: 1px solid #e5e7eb; background: #fff; text-decoration: none;
    transition: transform .2s cubic-bezier(.34,1.56,.64,1), border-color .2s ease, background .2s ease, box-shadow .2s ease; }
.qa-btn:hover { transform: translateY(-4px) scale(1.03); border-color: transparent; }
.qa-btn:active { transform: scale(.97); }
.qa-btn:focus-visible { outline: 3px solid #70a6f0; outline-offset: 2px; }
.qa-ico { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background .2s ease, box-shadow .2s ease, color .2s ease; flex-shrink: 0; }
.qa-ico i { line-height: 1; display: flex; transition: transform .22s cubic-bezier(.34,1.56,.64,1); }
.qa-btn:hover .qa-ico i { transform: scale(1.2); }
.qa-lbl { font-size: 12px; font-weight: 500; color: #6b7280; text-align: center; line-height: 1.3; transition: color .2s ease; }
.qa-count { position: absolute; top: 8px; right: 8px; min-width: 22px; height: 22px; padding: 0 6px; border-radius: 999px; background: #f3f4f6; color: #374151; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
.qa-count-alert { background: #dc2626; color: #fff; }
.qa-blue .qa-ico { background: #eff6ff; color: #2563eb; } .qa-blue:hover { background: #e8f0fe; box-shadow: 0 8px 24px rgba(37,99,235,.18); border-color: #bfdbfe; } .qa-blue:hover .qa-ico { background: #2563eb; color: #fff; box-shadow: 0 4px 14px rgba(37,99,235,.4); } .qa-blue:hover .qa-lbl { color: #1d4ed8; }
.qa-amber .qa-ico { background: #fffbeb; color: #d97706; } .qa-amber:hover { background: #fefce8; box-shadow: 0 8px 24px rgba(217,119,6,.16); border-color: #fde68a; } .qa-amber:hover .qa-ico { background: #d97706; color: #fff; box-shadow: 0 4px 14px rgba(217,119,6,.4); } .qa-amber:hover .qa-lbl { color: #b45309; }
.qa-slate .qa-ico { background: #f1f5f9; color: #64748b; } .qa-slate:hover { background: #f1f5f9; box-shadow: 0 8px 24px rgba(100,116,139,.16); border-color: #cbd5e1; } .qa-slate:hover .qa-ico { background: #475569; color: #fff; box-shadow: 0 4px 14px rgba(71,85,105,.38); } .qa-slate:hover .qa-lbl { color: #334155; }
.qa-green .qa-ico { background: #f0fdf4; color: #16a34a; } .qa-green:hover { background: #f0fdf4; box-shadow: 0 8px 24px rgba(22,163,74,.15); border-color: #bbf7d0; } .qa-green:hover .qa-ico { background: #16a34a; color: #fff; box-shadow: 0 4px 14px rgba(22,163,74,.4); } .qa-green:hover .qa-lbl { color: #15803d; }
.qa-purple .qa-ico { background: #faf5ff; color: #7c3aed; } .qa-purple:hover { background: #faf5ff; box-shadow: 0 8px 24px rgba(124,58,237,.15); border-color: #e9d5ff; } .qa-purple:hover .qa-ico { background: #7c3aed; color: #fff; box-shadow: 0 4px 14px rgba(124,58,237,.38); } .qa-purple:hover .qa-lbl { color: #6d28d9; }
.qa-rose .qa-ico { background: #fff1f2; color: #e11d48; } .qa-rose:hover { background: #fff1f2; box-shadow: 0 8px 24px rgba(225,29,72,.14); border-color: #fecdd3; } .qa-rose:hover .qa-ico { background: #e11d48; color: #fff; box-shadow: 0 4px 14px rgba(225,29,72,.38); } .qa-rose:hover .qa-lbl { color: #be123c; }
.chart-tab { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 9999px; border: 1px solid #e5e7eb; background: #fff; color: #6b7280; font-size: 12px; font-weight: 500; cursor: pointer; transition: background .2s ease, color .2s ease, border-color .2s ease, box-shadow .2s ease; }
.chart-tab:hover { background: #f9fafb; color: #374151; }
.chart-tab-active, .chart-tab-active:hover { background: #2563eb; border-color: #2563eb; color: #fff; box-shadow: 0 4px 12px rgba(37,99,235,.25); }
.chart-tab:focus-visible, .status-tab:focus-visible { outline: 3px solid #70a6f0; outline-offset: 2px; }
.status-tab { padding: 6px 8px; border-radius: 9px; font-size: 12px; font-weight: 600; color: #6b7280; transition: background .2s ease, color .2s ease, box-shadow .2s ease; }
.status-tab-active { background: #fff; color: #111827; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
.ppid-stat { transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
.ppid-stat:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(10,106,201,.10); border-color: #c5dcfa; }
.ppid-bar { width: 0; transition: width .9s cubic-bezier(.22,1,.36,1); }
.ppid-bar.is-in { width: var(--w); }
@media (prefers-reduced-motion: reduce) {
    .qa-btn, .qa-btn:hover, .ppid-stat, .ppid-stat:hover { transform: none; transition: none; }
    .ppid-bar { transition: none; }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
(function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var monthly = @json($monthly);
    var statusData = @json($statusChart);
    var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    var series = [
        { key: 'pemohon',   label: 'Permohonan', color: '#0A6AC9' },
        { key: 'keberatan', label: 'Keberatan',  color: '#7c3aed' }
    ];
    var fmt = function (n) { return Number(n).toLocaleString('id-ID'); };

    // Animasi bilah kategori
    requestAnimationFrame(function () {
        document.querySelectorAll('.ppid-bar').forEach(function (el) { el.classList.add('is-in'); });
    });

    // Angka berjalan pada kartu ringkasan
    if (!reduce) {
        document.querySelectorAll('[data-countup]').forEach(function (el) {
            var target = parseInt(el.dataset.countup, 10) || 0, start = null;
            var step = function (ts) {
                if (!start) start = ts;
                var p = Math.min(1, (ts - start) / 900);
                el.textContent = fmt(Math.round(target * (1 - Math.pow(1 - p, 3))));
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        });
    }


    // ── Unduh rekap bulanan (CSV) ─────────────────
    var rekap = @json($rekap);
    var jenisNama = { pemohon: 'permohonan', pengaduan: 'pengaduan', keberatan: 'keberatan' };
    window.ppidRekapCsv = function (jenis) {
        var rk = rekap[jenis]; if (!rk) return;
        var head = ['Bulan', 'Masuk'].concat(rk.final.map(function (f) { return 'Keluar - ' + f.label; }), ['Total Keluar', 'Belum Selesai']);
        var lines = [head];
        rk.rows.forEach(function (r) {
            lines.push([r.bulan, r.masuk].concat(rk.final.map(function (f) { return r.keluar[f.key]; }), [r.total_keluar, r.belum]));
        });
        lines.push(['Total {{ $year }}', rk.total.masuk].concat(rk.final.map(function (f) { return rk.total.keluar[f.key]; }), [rk.total.total_keluar, rk.total.belum]));
        var csv = '\ufeff' + lines.map(function (row) { return row.map(function (v) { return '"' + String(v).replace(/"/g, '""') + '"'; }).join(';'); }).join('\r\n');
        var a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
        a.download = 'rekap-bulanan-' + jenisNama[jenis] + '-{{ $year }}.csv';
        document.body.appendChild(a); a.click(); a.remove();
    };

    if (!window.Chart) return;
    Chart.defaults.font.family = "'Instrument Sans', ui-sans-serif, system-ui, sans-serif";
    Chart.defaults.color = '#6b7280';

    // ── Grafik bulanan ─────────────────────────────
    var current = 'all', chartType = 'bar', monthlyChart;
    var sub = document.getElementById('ppidChartSub');
    var totalEl = document.getElementById('ppidChartTotal');

    function buildMonthly() {
        if (monthlyChart) monthlyChart.destroy();
        var active = series.filter(function (s) { return current === 'all' || current === s.key; });
        monthlyChart = new Chart(document.getElementById('ppidMonthlyChart'), {
            type: chartType,
            data: {
                labels: labels,
                datasets: active.map(function (s) {
                    return {
                        label: s.label, data: monthly[s.key],
                        backgroundColor: chartType === 'bar' ? s.color : s.color + '22',
                        borderColor: s.color, borderWidth: 2, borderRadius: 6, maxBarThickness: 22,
                        tension: 0.35, fill: chartType === 'line' && current !== 'all', pointRadius: 3, pointHoverRadius: 6
                    };
                })
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                animation: reduce ? false : { duration: 700 },
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top', align: 'start', labels: { usePointStyle: true, boxWidth: 8 } },
                    tooltip: { callbacks: { label: function (c) { return ' ' + c.dataset.label + ': ' + fmt(c.parsed.y) + ' masuk'; } } }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(152,162,179,.2)' } }
                }
            }
        });
        var total = active.reduce(function (sum, s) { return sum + monthly[s.key].reduce(function (a, b) { return a + b; }, 0); }, 0);
        totalEl.textContent = fmt(total);
        sub.textContent = (current === 'all' ? 'Permohonan dan keberatan' : active[0].label) + ' tahun {{ $year }}';
    }

    function setActive(selector, btn) {
        document.querySelectorAll(selector).forEach(function (b) {
            b.classList.toggle('chart-tab-active', b === btn);
            b.setAttribute('aria-pressed', b === btn ? 'true' : 'false');
        });
    }
    document.querySelectorAll('[data-ppid-tab]').forEach(function (btn) {
        btn.addEventListener('click', function () { current = btn.dataset.ppidTab; setActive('[data-ppid-tab]', btn); buildMonthly(); });
    });
    document.querySelectorAll('[data-ppid-type]').forEach(function (btn) {
        btn.addEventListener('click', function () { chartType = btn.dataset.ppidType; setActive('[data-ppid-type]', btn); buildMonthly(); });
    });
    buildMonthly();

    // ── Diagram status ─────────────────────────────
    var statusChart, legend = document.getElementById('ppidStatusLegend'), statusTotal = document.getElementById('ppidStatusTotal');
    function buildStatus(key) {
        var d = statusData[key], total = d.data.reduce(function (a, b) { return a + b; }, 0);
        if (statusChart) statusChart.destroy();
        statusChart = new Chart(document.getElementById('ppidStatusChart'), {
            type: 'doughnut',
            data: { labels: d.labels, datasets: [{ data: total ? d.data : [1], backgroundColor: total ? d.colors : ['#e5e7eb'], borderWidth: 0, hoverOffset: 6 }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: '72%', animation: reduce ? false : { duration: 600 },
                plugins: { legend: { display: false }, tooltip: { enabled: total > 0 } } }
        });
        statusTotal.textContent = fmt(total);
        legend.innerHTML = d.labels.map(function (l, i) {
            var pct = total ? Math.round(d.data[i] / total * 100) : 0;
            return '<li class="flex items-center justify-between text-sm"><span class="flex items-center gap-2 text-gray-600">'
                + '<span class="w-2.5 h-2.5 rounded-full" style="background:' + d.colors[i] + '"></span>' + l + '</span>'
                + '<span class="tabular-nums"><strong class="text-gray-900">' + fmt(d.data[i]) + '</strong> <span class="text-gray-400 text-xs">(' + pct + '%)</span></span></li>';
        }).join('');
    }
    document.querySelectorAll('[data-status-tab]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('[data-status-tab]').forEach(function (b) {
                b.classList.toggle('status-tab-active', b === btn);
                b.setAttribute('aria-pressed', b === btn ? 'true' : 'false');
            });
            buildStatus(btn.dataset.statusTab);
        });
    });
    buildStatus('pemohon');
})();
</script>
@endpush