@extends('admin.layouts.master')

@section('title', 'Detail Pengaduan')
@section('page_title', 'Detail Pengaduan')

@section('content')
    <div class="p-6 space-y-6">
    <h1 class="font-heading text-xl font-semibold text-gray-900">{{ 'Pengaduan ' . $item->no_tiket }}</h1>

    @include('ppid.partials.flash')

    <a href="{{ route('ppid.pengaduan.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-gray-800">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 12.5 5.5 8 10 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Kembali ke daftar pengaduan
    </a>

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <section class="col-span-12 rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6 xl:col-span-8">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $item->subjek }}</h3>
                    <p class="text-sm text-gray-500">Dari {{ $item->nama }}, {{ $item->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                @include('ppid.partials.status-badge', ['label' => $item->status_label, 'color' => $item->status_color])
            </div>

            <p class="mt-5 max-w-prose whitespace-pre-line text-sm leading-6 text-gray-700">{{ $item->isi }}</p>

            <dl class="mt-6 divide-y divide-gray-100 border-t border-gray-100">
                @include('ppid.partials.detail-row', ['label' => 'Kategori', 'value' => \App\Models\PpidPengaduan::KATEGORI[$item->kategori] ?? $item->kategori])
                @include('ppid.partials.detail-row', ['label' => 'Email', 'value' => $item->email])
                @include('ppid.partials.detail-row', ['label' => 'Telepon', 'value' => $item->telepon])
            </dl>
        </section>

        <aside class="col-span-12 xl:col-span-4">
            <section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
                <h4 class="mb-4 text-sm font-semibold text-gray-800">Tindak lanjut</h4>
                @include('ppid.partials.status-form', [
                    'noteLabel' => 'Tanggapan',
                    'notePlaceholder' => 'Tanggapan yang disampaikan kepada pengadu.',
                ])
            </section>
        </aside>
    </div>
</div>
@endsection