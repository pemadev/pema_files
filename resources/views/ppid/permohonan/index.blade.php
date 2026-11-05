@extends('admin.layouts.master')

@section('title', 'Jumlah Pemohon')
@section('page_title', 'Jumlah Pemohon')

@section('content')
    <div class="p-6 space-y-6">
    <h1 class="font-heading text-xl font-semibold text-gray-900">Jumlah Pemohon</h1>

    @include('ppid.partials.flash')
    @include('ppid.partials.status-tabs')

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        @include('ppid.partials.filter-bar', ['searchPlaceholder' => 'Cari nama, email, NIK, atau no. registrasi'])

        @if ($items->isEmpty())
            @include('ppid.partials.empty', [
                'heading' => 'Belum ada permohonan informasi',
                'hint' => 'Permohonan yang masuk dari formulir e-PPID akan tampil di sini.',
            ])
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="border-b border-gray-200">
                        <tr class="text-xs font-medium text-gray-500">
                            <th scope="col" class="px-5 py-3 font-medium">No. registrasi</th>
                            <th scope="col" class="px-5 py-3 font-medium">Pemohon</th>
                            <th scope="col" class="px-5 py-3 font-medium">Informasi yang diminta</th>
                            <th scope="col" class="px-5 py-3 font-medium">Masuk</th>
                            <th scope="col" class="px-5 py-3 font-medium">Status</th>
                            <th scope="col" class="px-5 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($items as $item)
                            <tr class="align-top hover:bg-gray-50">
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-800 tabular-nums">{{ $item->no_registrasi }}</td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-medium text-gray-800">{{ $item->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->email }}</p>
                                    <p class="text-xs text-gray-500">{{ \App\Models\PpidPermohonan::KATEGORI_PEMOHON[$item->kategori_pemohon] ?? $item->kategori_pemohon }}</p>
                                </td>
                                <td class="max-w-md px-5 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($item->rincian_informasi, 110) }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 tabular-nums">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-col items-start gap-1">
                                        @include('ppid.partials.status-badge', ['label' => $item->status_label, 'color' => $item->status_color])
                                        @if ($item->terlambat)
                                            @include('ppid.partials.status-badge', ['label' => 'Lewat batas waktu', 'color' => 'error'])
                                        @endif
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <a href="{{ route('ppid.pemohon.show', $item->id) }}" class="text-sm font-medium text-pema-500 hover:text-pema-600">Lihat<span class="sr-only"> {{ $item->no_registrasi }}</span></a>
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