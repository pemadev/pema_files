@extends('admin.layouts.master')

@section('title', 'Detail Keberatan')
@section('page_title', 'Detail Keberatan')

@section('content')
    <div class="p-6 space-y-6">
    <h1 class="font-heading text-xl font-semibold text-gray-900">{{ 'Keberatan atas ' . $item->no_permohonan }}</h1>

    @include('ppid.partials.flash')

    <a href="{{ route('ppid.keberatan.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-gray-800">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 12.5 5.5 8 10 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Kembali ke daftar keberatan
    </a>

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <section class="col-span-12 rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6 xl:col-span-8 self-start">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $item->nama }}</h3>
                    <p class="text-sm text-gray-500">Masuk {{ $item->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                @include('ppid.partials.status-badge', ['label' => $item->status_label, 'color' => $item->status_color])
            </div>

            <dl class="mt-5 divide-y divide-gray-100">
                <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm text-gray-500">Permohonan terkait</dt>
                    <dd class="text-sm sm:col-span-2">
                        @if ($item->permohonan)
                            <a href="{{ route('ppid.pemohon.show', $item->permohonan->id) }}" class="font-medium text-pema-500 hover:text-pema-600">{{ $item->no_permohonan }}</a>
                            <span class="text-gray-500">({{ $item->permohonan->status_label }})</span>
                        @else
                            <span class="text-gray-800">{{ $item->no_permohonan }}</span>
                        @endif
                    </dd>
                </div>
                @include('ppid.partials.detail-row', ['label' => 'Alasan keberatan', 'value' => $item->alasan_pengajuan_keberatan, 'multiline' => true])
                @include('ppid.partials.detail-row', ['label' => 'Tujuan penggunaan informasi', 'value' => $item->tujuan_penggunaan_informasi, 'multiline' => true])
                @include('ppid.partials.detail-row', ['label' => 'Email', 'value' => $item->email])
                @include('ppid.partials.detail-row', ['label' => 'Telepon', 'value' => $item->telepon])
                @include('ppid.partials.detail-row', ['label' => 'Batas tanggapan', 'value' => $item->batas_waktu->translatedFormat('d F Y') . ' (30 hari kerja)'])
            </dl>

            <h4 class="mt-6 text-sm font-semibold text-gray-800">Kuasa hukum</h4>
            <dl class="divide-y divide-gray-100">
                @include('ppid.partials.detail-row', ['label' => 'Nama', 'value' => $item->nama_kuasa_hukum])
                @include('ppid.partials.detail-row', ['label' => 'Alamat', 'value' => $item->alamat_kuasa_hukum])
                @include('ppid.partials.detail-row', ['label' => 'Telepon', 'value' => $item->telepon_kuasa_hukum])
            </dl>
            @if ($item->user)
                <a href="{{ route('ppid.pengguna.show', $item->user->id) }}" class="mt-3 inline-block text-sm font-medium text-pema-500 hover:text-pema-600">Lihat profil pengaju</a>
            @endif
        </section>

        <aside class="col-span-12 space-y-6 xl:col-span-4">
            <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
                <h4 class="mb-4 text-sm font-semibold text-gray-800">Tanggapan atasan PPID</h4>
                @include('ppid.partials.status-form', [
                    'noteLabel' => 'Keterangan untuk pengaju',
                    'notePlaceholder' => 'Keputusan atasan PPID atas keberatan ini.',
                ])
            </section>
            @include('ppid.partials.status-history')
        </aside>
    </div>
</div>
@endsection
