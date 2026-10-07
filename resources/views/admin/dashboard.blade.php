@extends('admin.layouts.master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="p-6 space-y-6">
    <div class="bg-gray-200 rounded-xl shadow-sm border border-gray-200 p-5">
        <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:12px;">

            {{-- Bisnis --}}
            <a href="{{ route('admin.bisnis.index') }}" class="qa-btn qa-rose">
                 <div class="qa-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <span class="qa-lbl">Bisnis</span>
            </a>

            {{-- Tambah Berita --}}
            <a href="{{ route('admin.berita.create') }}" class="qa-btn qa-blue">
                <div class="qa-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <span class="qa-lbl">Tambah Berita</span>
            </a>

            {{-- Tambah Pengumuman --}}
            <a href="{{ route('admin.pengumuman.create') }}" class="qa-btn qa-amber">
                <div class="qa-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                    </svg>
                </div>
                <span class="qa-lbl">Pengumuman</span>
            </a>

            {{-- Tambah Agenda --}}
            <a href="{{ route('admin.agenda.create') }}" class="qa-btn qa-green">
                <div class="qa-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <span class="qa-lbl">Tambah Agenda</span>
            </a>

            {{-- Upload Galeri --}}
            <a href="{{ route('admin.galeri.create') }}" class="qa-btn qa-purple">
                <div class="qa-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <span class="qa-lbl">Upload Galeri</span>
            </a>

            {{-- Kelola Banner --}}
            <a href="{{ route('admin.banner.index') }}" class="qa-btn qa-slate">
                <div class="qa-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                </div>
                <span class="qa-lbl">Kelola Banner</span>
            </a>

        </div>
    </div>

    {{-- ================= GOOGLE ANALYTICS ================= --}}
    @if($analytics['available'])
        {{-- Kartu ringkasan --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-pema-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fi fi-rs-chart-line-up text-pema-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Page Views Bulan Ini</p>
                        <p class="text-lg font-heading font-semibold text-gray-900">{{ number_format($analytics['totalThisMonth']) }}</p>
                    </div>
                </div>
                <p class="text-xs mt-2 {{ $analytics['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $analytics['growth'] >= 0 ? '▲' : '▼' }} {{ abs($analytics['growth']) }}% vs bulan lalu
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fi fi-rs-calendar text-blue-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Page Views Bulan Lalu</p>
                        <p class="text-lg font-heading font-semibold text-gray-900">{{ number_format($analytics['totalLastMonth']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fi fi-rs-user text-green-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Pengunjung Hari Ini</p>
                        <p class="text-lg font-heading font-semibold text-gray-900">
                            {{ number_format($analytics['visitorsToday']) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Menu grafik: pilih grafik yang ditampilkan --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-4 py-3 flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-chart-line-up text-pema-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Menu Grafik</h3>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" data-chart-tab="all" class="chart-tab chart-tab-active">Semua Grafik</button>
                <button type="button" data-chart-tab="new" class="chart-tab">Website Baru</button>
                <button type="button" data-chart-tab="old" class="chart-tab">Website Lama</button>
            </div>
        </div>

        {{-- Grafik pengunjung: website baru & website lama --}}
        <div id="chartGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-4">

          {{-- Website baru --}}
            @php
             $totalVisitorsNew  = collect($analytics['chart']['visitors'] ?? [])->sum();
             $totalPageViewsNew = collect($analytics['chart']['pageViews'] ?? [])->sum();
            @endphp
    <div id="chartCardNew" class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="px-5 py-4 border-b border-gray-100">
        <h3 class="font-heading font-semibold text-gray-900 text-sm">Website Baru</h3>
        <p class="text-xs text-gray-400 mt-0.5">Pengunjung 30 hari terakhir</p>
    </div>
    <div class="p-5">
        <canvas id="visitorsChart" height="150"></canvas>

        {{-- ▼ TAMBAHAN: total website baru ▼ --}}
        <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t border-gray-50">
            <div>
                <p class="text-xs text-gray-400">Total Visitors (30 hari)</p>
                <p class="text-sm font-semibold text-gray-900">{{ number_format($totalVisitorsNew) }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Total Page Views (30 hari)</p>
                <p class="text-sm font-semibold text-gray-900">{{ number_format($totalPageViewsNew) }}</p>
            </div>
        </div>
        {{-- ▲ TAMBAHAN ▲ --}}
        </div>
        </div>

            
            {{-- Website lama --}}
            <div id="chartCardOld" class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="font-heading font-semibold text-gray-900 text-sm">Website Lama</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Pengunjung per bulan: 2025 (Jan-Des) &amp; 2026 (Jan-Mei)</p>
                </div>
                <div class="p-5">
                    @if($oldWebsite['available'])
                        <canvas id="oldWebsiteChart" height="150"></canvas>
                        <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t border-gray-50">
                            <div>
                                <p class="text-xs text-gray-400">Total 2025</p>
                                <p class="text-sm font-semibold text-gray-900">{{ number_format($oldWebsite['total2025']) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Total Jan-Mei 2026</p>
                                <p class="text-sm font-semibold text-gray-900">{{ number_format($oldWebsite['total2026']) }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-400 text-center py-10">
                            Data website lama belum tersedia.<br>
                            <span class="text-xs">Periksa ANALYTICS_OLD_PROPERTY_ID di .env dan akses service account.</span>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Halaman terpopuler --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Halaman Terpopuler</h3>
            </div>
            <div class="p-5">
                @if($analytics['topPages']->count() > 0)
                    <div class="space-y-3">
                        @foreach($analytics['topPages'] as $page)
                            <div class="flex items-center justify-between gap-3 pb-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                                <span class="text-sm text-gray-700 truncate" title="{{ $page['fullPageUrl'] ?? $page['pageTitle'] ?? '' }}">
                                    {{ $page['pageTitle'] ?? $page['fullPageUrl'] ?? '-' }}
                                </span>
                                <span class="text-xs font-medium text-gray-400 flex-shrink-0">{{ number_format($page['screenPageViews'] ?? 0) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 text-center py-4">Belum ada data.</p>
                @endif
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fi fi-rs-exclamation text-amber-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Google Analytics belum dikonfigurasi</p>
                    <p class="text-xs text-gray-400">Periksa kembali kredensial dan Property ID di file .env.</p>
                </div>
            </div>
        </div>
    @endif

        <!-- Berita Terbaru -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Berita Terbaru</h3>
                <a href="{{ route('admin.berita.index') }}" class="text-pema-500 hover:text-pema-600 text-xs font-medium">Lihat Semua</a>
            </div>
            <div class="p-5">
                @if($stats['berita_terbaru']->count() > 0)
                    <div class="space-y-3">
                        @foreach($stats['berita_terbaru'] as $berita)
                            <div class="flex items-start gap-3 pb-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                                 <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 mt-0.5 bg-gray-50">
                                     @if($berita->image)
                                         <img src="{{ asset('storage/' . $berita->image) }}" alt="" class="w-full h-full object-cover">
                                     @else
                                         <div class="w-full h-full flex items-center justify-center bg-pema-50">
                                             <i class="fi fi-rs-newspaper text-pema-400 text-sm"></i>
                                         </div>
                                     @endif
                                 </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $berita->title }}</p>
                                    <p class="text-xs text-gray-400">{{ $berita->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 text-center py-4">Belum ada berita.</p>
                @endif
            </div>
        </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                <i class="fi fi-rs-clock text-pema-500 text-sm"></i>
            </div>
            <h3 class="font-heading font-semibold text-gray-900 text-sm">Aktivitas Terbaru</h3>
        </div>
        <div class="p-5">
            @if($activities->count() > 0)
                <div class="space-y-4">
                    @foreach($activities as $activity)
                        <div class="flex items-start gap-3 text-sm">
                            <div class="w-7 h-7 rounded-full bg-pema-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-pema-600 font-semibold text-xs">{{ substr($activity->user->name ?? '?', 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-gray-700">
                                    <span class="font-medium text-gray-900">{{ $activity->user->name ?? 'System' }}</span>
                                    @if($activity->action === 'created')
                                        <span class="text-green-600">menambahkan</span>
                                    @elseif($activity->action === 'updated')
                                        <span class="text-amber-600">mengubah</span>
                                    @elseif($activity->action === 'deleted')
                                        <span class="text-red-600">menghapus</span>
                                    @endif
                                    {{ $activity->description }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-4">Belum ada aktivitas.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ── Base card ─────────────────────────────────── */
.qa-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 16px 8px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    text-decoration: none;
    transition:
        transform 0.2s cubic-bezier(.34,1.56,.64,1),
        border-color 0.2s ease,
        background 0.2s ease,
        box-shadow 0.2s ease;
}
.qa-btn:hover {
    transform: translateY(-4px) scale(1.03);
    border-color: transparent;
}
.qa-btn:active { transform: scale(0.97); }

/* ── Icon circle ───────────────────────────────── */
.qa-ico {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease, box-shadow 0.2s ease;
    flex-shrink: 0;
}
.qa-ico svg {
    transition: transform 0.22s cubic-bezier(.34,1.56,.64,1), color 0.2s ease;
}
.qa-btn:hover .qa-ico svg { transform: scale(1.2); }

/* ── Label ─────────────────────────────────────── */
.qa-lbl {
    font-size: 12px;
    font-weight: 500;
    color: #6b7280;
    text-align: center;
    line-height: 1.3;
    transition: color 0.2s ease;
}

/* ══ BLUE ══ */
.qa-blue .qa-ico            { background: #eff6ff; color: #2563eb; }
.qa-blue:hover              { background: #e8f0fe; box-shadow: 0 8px 24px rgba(37,99,235,.18); border-color: #bfdbfe; }
.qa-blue:hover .qa-ico      { background: #2563eb; color: #fff; box-shadow: 0 4px 14px rgba(37,99,235,.4); }
.qa-blue:hover .qa-lbl      { color: #1d4ed8; }

/* ══ AMBER ══ */
.qa-amber .qa-ico           { background: #fffbeb; color: #d97706; }
.qa-amber:hover             { background: #fefce8; box-shadow: 0 8px 24px rgba(217,119,6,.16); border-color: #fde68a; }
.qa-amber:hover .qa-ico     { background: #d97706; color: #fff; box-shadow: 0 4px 14px rgba(217,119,6,.4); }
.qa-amber:hover .qa-lbl     { color: #b45309; }

/* ══ SLATE ══ */
.qa-slate .qa-ico           { background: #f1f5f9; color: #64748b; }
.qa-slate:hover             { background: #f1f5f9; box-shadow: 0 8px 24px rgba(100,116,139,.16); border-color: #cbd5e1; }
.qa-slate:hover .qa-ico     { background: #475569; color: #fff; box-shadow: 0 4px 14px rgba(71,85,105,.38); }
.qa-slate:hover .qa-lbl     { color: #334155; }

/* ══ GREEN ══ */
.qa-green .qa-ico           { background: #f0fdf4; color: #16a34a; }
.qa-green:hover             { background: #f0fdf4; box-shadow: 0 8px 24px rgba(22,163,74,.15); border-color: #bbf7d0; }
.qa-green:hover .qa-ico     { background: #16a34a; color: #fff; box-shadow: 0 4px 14px rgba(22,163,74,.4); }
.qa-green:hover .qa-lbl     { color: #15803d; }

/* ══ PURPLE ══ */
.qa-purple .qa-ico          { background: #faf5ff; color: #7c3aed; }
.qa-purple:hover            { background: #faf5ff; box-shadow: 0 8px 24px rgba(124,58,237,.15); border-color: #e9d5ff; }
.qa-purple:hover .qa-ico    { background: #7c3aed; color: #fff; box-shadow: 0 4px 14px rgba(124,58,237,.38); }
.qa-purple:hover .qa-lbl    { color: #6d28d9; }

/* ══ ROSE ══ */
.qa-rose .qa-ico            { background: #fff1f2; color: #e11d48; }
.qa-rose:hover              { background: #fff1f2; box-shadow: 0 8px 24px rgba(225,29,72,.14); border-color: #fecdd3; }
.qa-rose:hover .qa-ico      { background: #e11d48; color: #fff; box-shadow: 0 4px 14px rgba(225,29,72,.38); }
.qa-rose:hover .qa-lbl      { color: #be123c; }

/* ══ MENU GRAFIK (tab) ══ */
.chart-tab {
    padding: 6px 14px;
    border-radius: 9999px;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    color: #6b7280;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
}
.chart-tab:hover { background: #f9fafb; color: #374151; }
.chart-tab-active,
.chart-tab-active:hover {
    background: #2563eb;
    border-color: #2563eb;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(37,99,235,.25);
}
</style>
@endpush

@if($analytics['available'])
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    // ── Website baru (30 hari terakhir) ─────────────────────────
    const chartNew = new Chart(document.getElementById('visitorsChart'), {
        type: 'line',
        data: {
            labels: @json($analytics['chart']['labels']),
            datasets: [
                {
                    label: 'Visitors',
                    data: @json($analytics['chart']['visitors']),
                    borderColor: '#e11d48',
                    backgroundColor: 'rgba(225,29,72,0.08)',
                    tension: 0.3,
                    fill: true,
                },
                {
                    label: 'Page Views',
                    data: @json($analytics['chart']['pageViews']),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.08)',
                    tension: 0.3,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
                x: { ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 8 } }
            }
        }
    });

    let chartOld = null;

    @if($oldWebsite['available'])
    // ── Website lama (2025 Jan-Des vs 2026 Jan-Mei) ─────────────
    chartOld = new Chart(document.getElementById('oldWebsiteChart'), {
        type: 'line',
        data: {
            labels: @json($oldWebsite['labels']),
            datasets: [
                {
                    label: '2025',
                    data: @json($oldWebsite['series2025']),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.08)',
                    tension: 0.3,
                    fill: true,
                },
                {
                    label: '2026 (Jan-Mei)',
                    data: @json($oldWebsite['series2026']),
                    borderColor: '#e11d48',
                    backgroundColor: 'rgba(225,29,72,0.08)',
                    tension: 0.3,
                    fill: true,
                    spanGaps: false,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
    @endif

    // ── Menu grafik (tab): Semua / Website Baru / Website Lama ──
    const chartTabs = document.querySelectorAll('[data-chart-tab]');
    const chartGrid = document.getElementById('chartGrid');
    const cardNew   = document.getElementById('chartCardNew');
    const cardOld   = document.getElementById('chartCardOld');

    function showCharts(mode) {
        cardNew.classList.toggle('hidden', mode === 'old');
        cardOld.classList.toggle('hidden', mode === 'new');
        chartGrid.classList.toggle('lg:grid-cols-2', mode === 'all');

        chartTabs.forEach(function (btn) {
            btn.classList.toggle('chart-tab-active', btn.dataset.chartTab === mode);
        });

        // Chart.js perlu di-resize setelah container tampil kembali
        requestAnimationFrame(function () {
            chartNew.resize();
            if (chartOld) chartOld.resize();
        });
    }

    chartTabs.forEach(function (btn) {
        btn.addEventListener('click', function () { showCharts(btn.dataset.chartTab); });
    });
</script>
@endpush
@endif