{{-- Pencarian, filter tahun/bulan, dan ekspor CSV (satu baris) --}}
@php
    $months = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $field = 'h-11 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 shadow-sm transition-all duration-200 hover:border-pema-300 focus:border-pema-400 focus:outline-none focus:ring-4 focus:ring-pema-500/15';
    $btn = 'inline-flex h-11 items-center justify-center gap-2 whitespace-nowrap rounded-xl px-4 text-sm font-medium transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2';
@endphp
<form method="GET" action="{{ route("ppid.{$routeName}.index") }}"
      x-data="{ q: @js($filters['q'] ?? ''), loading: false }" @submit="loading = true"
      class="flex flex-col gap-3 border-b border-gray-100 p-4 sm:p-5 lg:flex-row lg:items-center">
    @if (!empty($filters['status']))
        <input type="hidden" name="status" value="{{ $filters['status'] }}">
    @endif

    <div class="relative min-w-0 flex-1">
        <label class="sr-only" for="q">Cari</label>
        <i class="fi fi-rs-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input id="q" type="search" name="q" x-model="q" @input.debounce.700ms="$el.form.requestSubmit()"
               placeholder="{{ $searchPlaceholder }}" autocomplete="off"
               class="{{ $field }} w-full pl-11 pr-10 placeholder:text-gray-400">
        <button type="button" x-show="q.length" x-cloak @click="q = ''; $nextTick(() => $el.form.requestSubmit())"
                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700" aria-label="Hapus pencarian">
            <i class="fi fi-rs-cross-small text-base"></i>
        </button>
    </div>

    <div class="flex gap-3">
        <label class="sr-only" for="tahun">Tahun</label>
        <select id="tahun" name="tahun" class="{{ $field }} w-full cursor-pointer px-4 lg:w-36" onchange="this.form.requestSubmit()">
            <option value="">Semua tahun</option>
            @foreach ($years as $y)
                <option value="{{ $y }}" @selected(($filters['tahun'] ?? '') == $y)>{{ $y }}</option>
            @endforeach
        </select>

        <label class="sr-only" for="bulan">Bulan</label>
        <select id="bulan" name="bulan" class="{{ $field }} w-full cursor-pointer px-4 lg:w-40" onchange="this.form.requestSubmit()">
            <option value="">Semua bulan</option>
            @foreach ($months as $num => $name)
                <option value="{{ $num }}" @selected(($filters['bulan'] ?? '') == $num)>{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex shrink-0 gap-2 lg:ml-auto">
        <button type="submit" class="{{ $btn }} bg-pema-500 text-white shadow-md shadow-pema-500/25 hover:bg-pema-600 hover:shadow-lg focus-visible:ring-pema-400">
            <i class="fi fi-rs-search" x-show="!loading"></i>
            <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" opacity=".25"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
            Cari
        </button>
        @if (array_filter($filters))
            <a href="{{ route("ppid.{$routeName}.index") }}" class="{{ $btn }} border border-gray-200 bg-white text-gray-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600 focus-visible:ring-red-300">
                <i class="fi fi-rs-rotate-left"></i>
                Reset
            </a>
        @endif
        <a href="{{ route("ppid.{$routeName}.export", $filters) }}" class="{{ $btn }} border border-green-200 bg-green-50 text-green-700 hover:border-green-600 hover:bg-green-600 hover:text-white hover:shadow-lg hover:shadow-green-600/25 focus-visible:ring-green-400">
            <i class="fi fi-rs-download"></i>
            Ekspor CSV
        </a>
    </div>
</form>