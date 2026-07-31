{{--
    resources/views/partials/statistik-pema.blade.php

    Versi DINAMIS: menerima variabel $statistik (koleksi StatistikPema)
    dari Controller. Data dikelola lewat halaman admin /admin/statistik.

    Ditempatkan SEBELUM section "Mitra Kerja Sama" di halaman Beranda:

        // di HomeController@index
        $statistik = \App\Models\StatistikPema::aktif()->get();
        return view('home', compact('statistik'));

        // di resources/views/home.blade.php
        @include('partials.statistik-pema')
        @include('partials.mitra-kerja-sama')
--}}

@if ($statistik->isNotEmpty())
<section
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    aria-labelledby="statistik-pema-heading"
    class="relative bg-white py-20 sm:py-24"
>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Eyebrow + Heading --}}
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider text-[#C9A15A]">
                <span class="h-px w-8 bg-[#C9A15A]"></span>
                Statistik
            </span>
            <h2 id="statistik-pema-heading" class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">
                Capaian PT PEMA dalam Angka
            </h2>
            <p class="mt-3 text-slate-500 text-base sm:text-lg">
                Rangkuman kinerja dan kontribusi PT Pembangunan Aceh (Perseroda) bagi perekonomian Aceh.
            </p>
        </div>

        {{-- Stat grid --}}
        <div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
            @foreach ($statistik as $index => $item)
                <div class="relative pl-6 border-l-2 border-slate-200">
                    <span
                        class="absolute -left-[2px] top-0 h-0 w-[2px] bg-gradient-to-b from-[#0B5FA8] to-[#2CA6A4] transition-all duration-700 ease-out"
                        :class="shown ? 'h-full' : 'h-0'"
                        style="transition-delay: {{ $index * 90 }}ms"
                    ></span>

                    <p class="text-sm font-medium text-slate-500">
                        {{ $item->label }}
                    </p>

                    <p class="mt-2 text-4xl sm:text-5xl font-bold tracking-tight text-slate-900"
                       x-data="{
                           display: 0,
                           target: {{ $item->value }},
                           decimals: {{ $item->decimals }},
                       }"
                       x-init="$watch('shown', value => {
                            if (!value) return;
                            let start = null;
                            const duration = 1200;
                            const step = (ts) => {
                                if (!start) start = ts;
                                const progress = Math.min((ts - start) / duration, 1);
                                display = (target * progress).toFixed(decimals);
                                if (progress < 1) requestAnimationFrame(step);
                            };
                            requestAnimationFrame(step);
                       })"
                    >
                        <span>{{ $item->prefix }}</span><span x-text="display">0</span><span>{{ $item->suffix }}</span>
                    </p>

                    @if ($item->deskripsi)
                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                            {{ $item->deskripsi }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif