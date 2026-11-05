@php
    $badgeClasses = [
        'success' => 'bg-green-50 text-green-700 ring-green-600/20',
        'warning' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'error'   => 'bg-red-50 text-red-700 ring-red-600/20',
        'brand'   => 'bg-pema-50 text-pema-700 ring-pema-600/20',
        'gray'    => 'bg-gray-100 text-gray-700 ring-gray-500/20',
    ];
@endphp
<span class="inline-flex items-center whitespace-nowrap rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $badgeClasses[$color ?? 'gray'] ?? $badgeClasses['gray'] }}">{{ $label }}</span>