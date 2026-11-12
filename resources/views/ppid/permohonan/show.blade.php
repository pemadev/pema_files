@extends('admin.layouts.master')

@section('title', 'Detail Permohonan')
@section('page_title', 'Detail Permohonan')

@section('content')
    <div class="p-6 space-y-6">
    <h1 class="font-heading text-xl font-semibold text-gray-900">{{ 'Permohonan ' . $item->no_permohonan }}</h1>

    @include('ppid.partials.flash')

    <a href="{{ route('ppid.pengguna.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-gray-800">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 12.5 5.5 8 10 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Kembali ke daftar pemohon informasi
    </a>

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-8">
            <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $item->nama }}</h3>
                        <p class="text-sm text-gray-500">Masuk {{ $item->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @include('ppid.partials.status-badge', ['label' => $item->status_label, 'color' => $item->status_color])
                        @if ($item->terlambat)
                            @include('ppid.partials.status-badge', ['label' => 'Lewat batas waktu', 'color' => 'error'])
                        @endif
                    </div>
                </div>

                <h4 class="mt-6 text-sm font-semibold text-gray-800">Informasi yang diminta</h4>
                <dl class="divide-y divide-gray-100">
                    @include('ppid.partials.detail-row', ['label' => 'Rincian informasi', 'value' => $item->rincian_informasi, 'multiline' => true])
                    @include('ppid.partials.detail-row', ['label' => 'Tujuan penggunaan', 'value' => $item->tujuan_penggunaan, 'multiline' => true])
                    @include('ppid.partials.detail-row', ['label' => 'Cara memperoleh', 'value' => implode(', ', (array) $item->cara_memperoleh_informasi)])
                    @include('ppid.partials.detail-row', ['label' => 'Bentuk salinan', 'value' => implode(', ', (array) $item->bentuk_salinan_informasi)])
                    @include('ppid.partials.detail-row', ['label' => 'Cara mendapatkan salinan', 'value' => $item->cara_mendapatkan_salinan])
                    @include('ppid.partials.detail-row', ['label' => 'Batas waktu jawaban', 'value' => $item->batas_waktu->translatedFormat('d F Y') . ' (10 hari kerja)'])
                </dl>

                <h4 class="mt-6 text-sm font-semibold text-gray-800">Data pemohon</h4>
                <dl class="divide-y divide-gray-100">
                    @include('ppid.partials.detail-row', ['label' => 'Kategori', 'value' => $item->user?->kategori?->kategori_pemohon])
                    @include('ppid.partials.detail-row', ['label' => 'No. KTP', 'value' => $item->user?->no_ktp])
                    @include('ppid.partials.detail-row', ['label' => 'Email', 'value' => $item->email])
                    @include('ppid.partials.detail-row', ['label' => 'Telepon', 'value' => $item->telepon])
                    @include('ppid.partials.detail-row', ['label' => 'Alamat', 'value' => $item->user?->alamat])
                </dl>
                @if ($item->user)
                    <a href="{{ route('ppid.pengguna.show', $item->user->id) }}" class="mt-3 inline-block text-sm font-medium text-pema-500 hover:text-pema-600">Lihat profil pemohon</a>
                @endif
            </section>

            @if ($item->keberatan->isNotEmpty())
                <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
                    <h4 class="text-sm font-semibold text-gray-800">Keberatan atas permohonan ini</h4>
                    <ul class="mt-3 divide-y divide-gray-100">
                        @foreach ($item->keberatan as $kbr)
                            <li class="flex flex-wrap items-center justify-between gap-2 py-3">
                                <a href="{{ route('ppid.keberatan.show', $kbr->id) }}" class="text-sm font-medium text-pema-500 hover:text-pema-600">Keberatan {{ $kbr->created_at->translatedFormat('d F Y') }}</a>
                                @include('ppid.partials.status-badge', ['label' => $kbr->status_label, 'color' => $kbr->status_color])
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </div>

        <aside class="col-span-12 space-y-6 xl:col-span-4">
            <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
                <h4 class="mb-4 text-sm font-semibold text-gray-800">Proses permohonan</h4>
                @include('ppid.partials.status-form', [
                    'noteLabel' => 'Keterangan untuk pemohon',
                    'notePlaceholder' => 'Mis. informasi sudah dikirim ke email, atau alasan penolakan.',
                ])
            </section>
            @include('ppid.partials.status-history')
        </aside>
    </div>
</div>
@endsection
