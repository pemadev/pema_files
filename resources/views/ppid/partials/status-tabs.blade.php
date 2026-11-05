{{-- Tab status dengan jumlah; klik untuk menyaring --}}
@php
    $current = $filters['status'] ?? null;
    $base = array_diff_key($filters, ['status' => true, 'page' => true]);
    $all = $statusCounts->sum();
    $dot = ['success' => 'bg-green-500', 'warning' => 'bg-amber-500', 'error' => 'bg-red-500', 'brand' => 'bg-pema-500', 'gray' => 'bg-gray-400'];
    $tab = 'group inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pema-400 focus-visible:ring-offset-2';
    $on = 'bg-pema-500 text-white shadow-md shadow-pema-500/25';
    $off = 'text-gray-600 hover:bg-pema-50 hover:text-pema-600 hover:-translate-y-0.5';
    $countOn = 'bg-white/20 text-white';
    $countOff = 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-pema-600';
@endphp
<nav aria-label="Saring berdasarkan status" class="flex flex-wrap gap-1.5 rounded-2xl border border-gray-100 bg-white p-1.5 shadow-sm">
    <a href="{{ route("ppid.{$routeName}.index", $base) }}" class="{{ $tab }} {{ $current ? $off : $on }}" @if (!$current) aria-current="page" @endif>
        Semua
        <span class="rounded-full px-2 py-0.5 text-xs font-semibold tabular-nums transition-colors {{ $current ? $countOff : $countOn }}">{{ number_format($all, 0, ',', '.') }}</span>
    </a>
    @foreach ($statuses as $key => $def)
        @php $active = $current === $key; @endphp
        <a href="{{ route("ppid.{$routeName}.index", $base + ['status' => $key]) }}"
           class="{{ $tab }} {{ $active ? $on : $off }}" @if ($active) aria-current="page" @endif>
            <span class="h-2 w-2 rounded-full {{ $active ? 'bg-white' : ($dot[$def['color']] ?? 'bg-gray-400') }}" aria-hidden="true"></span>
            {{ $def['label'] }}
            <span class="rounded-full px-2 py-0.5 text-xs font-semibold tabular-nums transition-colors {{ $active ? $countOn : $countOff }}">{{ number_format($statusCounts[$key] ?? 0, 0, ',', '.') }}</span>
        </a>
    @endforeach
</nav>