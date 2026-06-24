@php
    $banners = \App\Models\Banner::where('is_active', true)->orderBy('sort_order')->get();
@endphp
@if($banners->count() > 0)
<div x-data="{ current: 0, total: {{ $banners->count() }}, timer: null }"
     x-init="if(total > 1) timer = setInterval(() => { current = (current + 1) % total }, 4000)"
     class="w-full">
    <div class="relative rounded-xl overflow-hidden bg-gray-100" style="aspect-ratio: 1/1">
        @foreach($banners as $i => $banner)
            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? '' }}"
                 x-show="current === {{ $i }}"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 w-full h-full object-contain rounded-xl bg-gray-50">
        @endforeach

        @if($banners->count() > 1)
            <div class="absolute inset-0 flex items-center justify-between pointer-events-none z-10 px-3">
                <button @click="clearInterval(timer); current = (current - 1 + total) % total; timer = setInterval(() => { current = (current + 1) % total }, 4000)"
                        class="pointer-events-auto w-8 h-8 rounded-full bg-white/90 hover:bg-white flex items-center justify-center shadow-md backdrop-blur-sm transition-all">
                    <svg class="w-4 h-4 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="clearInterval(timer); current = (current + 1) % total; timer = setInterval(() => { current = (current + 1) % total }, 4000)"
                        class="pointer-events-auto w-8 h-8 rounded-full bg-white/90 hover:bg-white flex items-center justify-center shadow-md backdrop-blur-sm transition-all">
                    <svg class="w-4 h-4 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
                @foreach($banners as $i => $banner)
                    <button @click="clearInterval(timer); current = {{ $i }}; timer = setInterval(() => { current = (current + 1) % total }, 4000)"
                            :class="current === {{ $i }} ? 'bg-gold-500 w-3 h-3' : 'bg-gray-300/70 hover:bg-gray-300 w-3 h-3'" class="rounded-full transition-all duration-300"></button>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endif
