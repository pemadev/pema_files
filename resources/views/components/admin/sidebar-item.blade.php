@props(['icon', 'href', 'active' => false, 'label', 'badge' => null])

<a href="{{ $href }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $active ? 'bg-pema-50 text-pema-600 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
     <i class="{{ $icon }} {{ $active ? 'text-pema-500' : 'text-gray-400' }} text-lg"></i>
     <span class="flex-1">{{ $label }}</span>
     @if($badge && $badge > 0)
     <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 bg-red-500 text-white text-xs font-bold rounded-full">
         {{ $badge > 99 ? '99+' : $badge }}
     </span>
     @endif
 </a>
