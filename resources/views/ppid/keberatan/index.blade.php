@extends('admin.layouts.master')

@section('title', 'Keberatan')
@section('page_title', 'Keberatan')

@section('content')
    <div class="p-6 space-y-6">
    <h1 class="font-heading text-xl font-semibold text-gray-900">Keberatan</h1>

    @include('ppid.partials.flash')
    @include('ppid.partials.status-tabs')

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
        @include('ppid.partials.filter-bar', ['searchPlaceholder' => 'Cari nama, email, alasan, kuasa hukum, atau no. permohonan'])

        @if ($items->isEmpty())
            @include('ppid.partials.empty', [
                'heading' => 'Belum ada keberatan',
                'hint' => 'Keberatan atas permohonan informasi dari portal PPID akan tampil di sini.',
            ])
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="border-b border-gray-200">
                        <tr class="text-xs font-medium text-gray-500">
                            <th scope="col" class="px-5 py-3 font-medium">Permohonan terkait</th>
                            <th scope="col" class="px-5 py-3 font-medium">Pengaju</th>
                            <th scope="col" class="px-5 py-3 font-medium">Alasan keberatan</th>
                            <th scope="col" class="px-5 py-3 font-medium">Masuk</th>
                            <th scope="col" class="px-5 py-3 font-medium">Status</th>
                            <th scope="col" class="px-5 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($items as $item)
                            <tr class="align-top hover:bg-gray-50">
                                <td class="whitespace-nowrap px-5 py-4 text-sm tabular-nums">
                                    @if ($item->permohonan)
                                        <a href="{{ route('ppid.pemohon.show', $item->permohonan->id) }}" class="font-medium text-pema-500 hover:text-pema-600">{{ $item->no_permohonan }}</a>
                                    @else
                                        <span class="font-medium text-gray-800">{{ $item->no_permohonan }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-medium text-gray-800">{{ $item->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->email }}</p>
                                </td>
                                <td class="max-w-sm px-5 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($item->alasan_pengajuan_keberatan, 110) }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 tabular-nums">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="px-5 py-4">@include('ppid.partials.status-badge', ['label' => $item->status_label, 'color' => $item->status_color])</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <a href="{{ route('ppid.keberatan.show', $item->id) }}" class="text-sm font-medium text-pema-500 hover:text-pema-600">Lihat<span class="sr-only"> keberatan {{ $item->no_permohonan }}</span></a>
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
