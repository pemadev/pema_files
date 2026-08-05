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
</style>
@endpush