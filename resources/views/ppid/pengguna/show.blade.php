@extends('admin.layouts.master')

@section('title', 'Detail Pemohon')
@section('page_title', 'Detail Pemohon')

@php
    $fmt = fn ($n) => number_format((int) $n, 0, ',', '.');
    $dot = ['success' => 'bg-green-500', 'warning' => 'bg-amber-500', 'error' => 'bg-red-500', 'brand' => 'bg-pema-500', 'gray' => 'bg-gray-400'];
    $btn = 'inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-xl px-4 text-sm font-medium transition-all duration-200 hover:-translate-y-0.5 active:scale-95';
    $initials = collect(preg_split('/\s+/', trim($item->name)))->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
    $tiles = [
        ['label' => 'Permohonan',    'value' => $stats['permohonan'], 'icon' => 'fi fi-rs-document',     'bg' => 'bg-pema-50',   'fg' => 'text-pema-500'],
        ['label' => 'Keberatan',     'value' => $stats['keberatan'],  'icon' => 'fi fi-rs-scale',        'bg' => 'bg-purple-50', 'fg' => 'text-purple-600'],
        ['label' => 'Selesai',       'value' => $stats['selesai'],    'icon' => 'fi fi-rs-check-circle', 'bg' => 'bg-green-50',  'fg' => 'text-green-600'],
        ['label' => 'Masih berjalan','value' => $stats['berjalan'],   'icon' => 'fi fi-rs-hourglass-end','bg' => 'bg-amber-50',  'fg' => 'text-amber-600'],
    ];
@endphp

@section('content')
<div class="p-6 space-y-6">
    <a href="{{ route('ppid.akun.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-gray-800">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 12.5 5.5 8 10 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Kembali ke daftar pemohon
    </a>

    {{-- ================= PROFIL ================= --}}
    <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
            <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-pema-500 text-xl font-semibold text-white shadow-md shadow-pema-500/25">{{ $initials ?: '?' }}</div>
            <div class="min-w-0 flex-1">
                <h1 class="font-heading text-xl font-semibold text-gray-900 truncate">{{ $item->name }}</h1>
                <div class="mt-1.5 flex flex-wrap items-center gap-2">
                    @include('ppid.partials.status-badge', ['label' => $item->active ? 'Akun aktif' : 'Akun nonaktif', 'color' => $item->active ? 'success' : 'gray'])
                    @if ($item->kategori)
                        @include('ppid.partials.status-badge', ['label' => $item->kategori->kategori_pemohon, 'color' => 'brand'])
                    @endif
                    @if ($stats['terlambat'] > 0)
                        @include('ppid.partials.status-badge', ['label' => $stats['terlambat'] . ' lewat batas waktu', 'color' => 'error'])
                    @endif
                    <span class="text-xs text-gray-400">Terdaftar {{ $item->created_at?->translatedFormat('d F Y') }} · {{ $item->created_at?->diffForHumans() }}</span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="mailto:{{ $item->email }}" class="{{ $btn }} border border-gray-200 bg-white text-gray-700 hover:border-pema-300 hover:bg-pema-50 hover:text-pema-600">
                    <i class="fi fi-rs-envelope"></i> Email
                </a>
                @if ($whatsapp)
                    <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="{{ $btn }} bg-green-600 text-white shadow-md hover:bg-green-700">
                        <i class="fi fi-rs-comment"></i> WhatsApp
                    </a>
                @endif
                @if ($item->telepon)
                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $item->telepon) }}" class="{{ $btn }} border border-gray-200 bg-white text-gray-700 hover:border-pema-300 hover:bg-pema-50 hover:text-pema-600">
                        <i class="fi fi-rs-phone-call"></i> Telepon
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3 lg:grid-cols-4">
            @foreach ($tiles as $t)
                <div class="flex items-center gap-3 rounded-xl border border-gray-100 p-4">
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg {{ $t['bg'] }}"><i class="{{ $t['icon'] }} {{ $t['fg'] }}"></i></div>
                    <div>
                        <p class="text-xs text-gray-400">{{ $t['label'] }}</p>
                        <p class="font-heading text-lg font-semibold text-gray-900 tabular-nums">{{ $fmt($t['value']) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        {{-- ================= DATA DIRI ================= --}}
        <div class="col-span-12 space-y-6 xl:col-span-5">
            <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
                <h2 class="text-sm font-semibold text-gray-800">Data diri</h2>
                <dl class="mt-2 divide-y divide-gray-100">
                    @include('ppid.partials.detail-row', ['label' => 'Nama', 'value' => $item->name])
                    @include('ppid.partials.detail-row', ['label' => 'No. KTP', 'value' => $item->no_ktp])
                    @include('ppid.partials.detail-row', ['label' => 'Kategori', 'value' => $item->kategori?->kategori_pemohon])
                    @include('ppid.partials.detail-row', ['label' => 'Email', 'value' => $item->email])
                    @include('ppid.partials.detail-row', ['label' => 'Telepon', 'value' => $item->telepon])
                </dl>
            </section>

            <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
                <h2 class="text-sm font-semibold text-gray-800">Alamat</h2>
                <dl class="mt-2 divide-y divide-gray-100">
                    @include('ppid.partials.detail-row', ['label' => 'Kelurahan / desa', 'value' => $item->kelurahan_desa])
                    @include('ppid.partials.detail-row', ['label' => 'Kecamatan', 'value' => $item->kecamatan])
                    @include('ppid.partials.detail-row', ['label' => 'Kabupaten / kota', 'value' => $item->kabupaten_kota])
                    @include('ppid.partials.detail-row', ['label' => 'Provinsi', 'value' => $item->provinsi])
                    @include('ppid.partials.detail-row', ['label' => 'Kode pos', 'value' => $item->kode_pos])
                </dl>
            </section>

            <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
                <h2 class="text-sm font-semibold text-gray-800">Dokumen</h2>
                <ul class="mt-3 space-y-2">
                    @foreach (['KTP' => $item->file_ktp, 'Surat pengantar' => $item->file_surat_pengantar] as $label => $file)
                        <li class="flex items-center gap-3 rounded-xl border border-gray-100 px-3 py-2.5">
                            <i class="fi fi-rs-file {{ $file ? 'text-pema-500' : 'text-gray-300' }}"></i>
                            <div class="min-w-0">
                                <p class="text-sm text-gray-800">{{ $label }}</p>
                                <p class="text-xs truncate {{ $file ? 'text-gray-500' : 'text-gray-400' }}">{{ $file ?: 'Tidak diunggah' }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <p class="mt-3 text-xs text-gray-400">File tersimpan di server portal PPID, jadi di sini hanya nama filenya yang ditampilkan.</p>
            </section>
        </div>

        <div class="col-span-12 space-y-6 xl:col-span-7">
            {{-- ================= PENGAJUAN ================= --}}
            <section class="rounded-2xl border border-gray-100 bg-white shadow-sm" x-data="{ tab: 'permohonan' }">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-5 py-4">
                    <h2 class="text-sm font-semibold text-gray-800">Pengajuan</h2>
                    <div class="flex gap-2" role="group" aria-label="Pilih jenis pengajuan">
                        <button type="button" @click="tab = 'permohonan'" :class="tab === 'permohonan' ? 'chart-tab chart-tab-active' : 'chart-tab'" :aria-pressed="tab === 'permohonan'">Permohonan ({{ $stats['permohonan'] }})</button>
                        <button type="button" @click="tab = 'keberatan'" :class="tab === 'keberatan' ? 'chart-tab chart-tab-active' : 'chart-tab'" :aria-pressed="tab === 'keberatan'">Keberatan ({{ $stats['keberatan'] }})</button>
                    </div>
                </div>

                <div x-show="tab === 'permohonan'">
                    @forelse ($item->permohonan as $r)
                        <a href="{{ route('ppid.pemohon.show', $r->id) }}" class="flex items-start justify-between gap-3 border-b border-gray-100 px-5 py-4 last:border-b-0 hover:bg-gray-50 transition-colors">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-pema-500 tabular-nums">{{ $r->no_permohonan }}</p>
                                <p class="mt-0.5 text-sm text-gray-700 line-clamp-2">{{ $r->rincian_informasi }}</p>
                                <p class="mt-1 text-xs text-gray-400">
                                    Masuk {{ $r->created_at->translatedFormat('d M Y') }}
                                    @if ($r->tanggal_selesai)
                                        · selesai {{ $r->tanggal_selesai->translatedFormat('d M Y') }}
                                    @else
                                        · batas {{ $r->batas_waktu->translatedFormat('d M Y') }}
                                    @endif
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                @include('ppid.partials.status-badge', ['label' => $r->status_label, 'color' => $r->status_color])
                                @if ($r->terlambat)
                                    @include('ppid.partials.status-badge', ['label' => 'Lewat batas', 'color' => 'error'])
                                @endif
                            </div>
                        </a>
                    @empty
                        <p class="px-5 py-10 text-center text-sm text-gray-400">Belum pernah mengajukan permohonan informasi.</p>
                    @endforelse
                </div>

                <div x-show="tab === 'keberatan'" x-cloak>
                    @forelse ($item->keberatan as $r)
                        <a href="{{ route('ppid.keberatan.show', $r->id) }}" class="flex items-start justify-between gap-3 border-b border-gray-100 px-5 py-4 last:border-b-0 hover:bg-gray-50 transition-colors">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-pema-500 tabular-nums">Keberatan atas {{ $r->no_permohonan }}</p>
                                <p class="mt-0.5 text-sm text-gray-700 line-clamp-2">{{ $r->alasan_pengajuan_keberatan }}</p>
                                <p class="mt-1 text-xs text-gray-400">Masuk {{ $r->created_at->translatedFormat('d M Y') }}</p>
                            </div>
                            @include('ppid.partials.status-badge', ['label' => $r->status_label, 'color' => $r->status_color])
                        </a>
                    @empty
                        <p class="px-5 py-10 text-center text-sm text-gray-400">Belum pernah mengajukan keberatan.</p>
                    @endforelse
                </div>
            </section>

            {{-- ================= LINIMASA ================= --}}
            <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
                <h2 class="mb-4 text-sm font-semibold text-gray-800">Riwayat aktivitas</h2>
                @if ($aktivitas->isEmpty())
                    <p class="text-sm text-gray-400">Belum ada aktivitas.</p>
                @else
                    <div class="overflow-y-auto pr-1" style="max-height: 520px">
                        <ol class="relative space-y-5 border-l border-gray-200 pl-5 ml-1.5">
                            @foreach ($aktivitas as $a)
                                <li class="relative">
                                    <span class="absolute top-1 h-3 w-3 rounded-full {{ $dot[$a['color']] ?? 'bg-gray-400' }}" style="left:-26px; box-shadow:0 0 0 4px #fff" aria-hidden="true"></span>
                                    <div class="flex flex-wrap items-center gap-2">
                                        @include('ppid.partials.status-badge', ['label' => $a['label'], 'color' => $a['color']])
                                        <a href="{{ $a['url'] }}" class="text-sm font-medium text-gray-800 hover:text-pema-600">{{ $a['jenis'] }} {{ $a['nomor'] }}</a>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">{{ $a['info'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $a['date']?->translatedFormat('d F Y, H:i') }} · oleh {{ $a['oleh'] }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
