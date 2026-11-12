{{-- Riwayat status dari tabel status di server (terlama di atas) --}}
@php
    $dot = ['success' => 'bg-green-500', 'warning' => 'bg-amber-500', 'error' => 'bg-red-500', 'brand' => 'bg-pema-500', 'gray' => 'bg-gray-400'];
@endphp
<section class="rounded-2xl border border-gray-100 bg-white shadow-sm p-5 sm:p-6">
    <h4 class="mb-4 text-sm font-semibold text-gray-800">Riwayat status</h4>
    @if ($item->statuses->isEmpty())
        <p class="text-sm text-gray-400">Belum ada riwayat status.</p>
    @else
        <ol class="relative space-y-5 border-l border-gray-200 pl-5">
            @foreach ($item->statuses as $s)
                <li class="relative">
                    <span class="absolute top-1 h-3 w-3 rounded-full {{ $dot[$s->color] ?? 'bg-gray-400' }}" style="left:-26px; box-shadow:0 0 0 4px #fff" aria-hidden="true"></span>
                    <div class="flex flex-wrap items-center gap-2">
                        @include('ppid.partials.status-badge', ['label' => $s->label, 'color' => $s->color])
                        <span class="text-xs text-gray-400">{{ $s->created_at?->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-700 whitespace-pre-line">{{ $s->info }}</p>
                    <p class="text-xs text-gray-400">oleh {{ $s->status_by }}</p>
                </li>
            @endforeach
        </ol>
    @endif
</section>
