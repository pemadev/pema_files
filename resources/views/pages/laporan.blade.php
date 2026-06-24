@extends('layouts.app')

@section('title', 'Laporan - PT PEMA')
@section('meta_description', 'Laporan tahunan dan dokumen resmi PT Pembangunan Aceh (PEMA) — Transparansi dan akuntabilitas perusahaan.')

@push('styles')
<style>
.pdf-viewer-modal {
    backdrop-filter: blur(8px);
}
.pdf-viewer-modal .pdf-container {
    position: absolute;
    top: 60px;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 8px;
    background: #f9fafb;
    overflow: hidden;
}
.pdf-viewer-modal iframe {
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 0.5rem;
    background: #e5e7eb;
}
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="relative pt-20 pb-16 lg:pb-20 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 -right-20 w-96 h-96 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="max-w-3xl">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">
                    Dokumen
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                <span class="gradient-gold">Laporan</span> perusahaan
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                Laporan tahunan dan dokumen resmi PT Pembangunan Aceh (PEMA) sebagai wujud transparansi dan akuntabilitas perusahaan.
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter -->
<section class="py-8 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" placeholder="Cari judul laporan..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-400 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all outline-none">
            </div>
            @if($years && $years->count() > 0)
            <div>
                <select name="year" class="px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white outline-none">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <button type="submit" class="px-5 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                <i class="fi fi-rs-search"></i>
            </button>
            @if(request('search') || request('year'))
                <a href="{{ url()->current() }}" class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Laporan List -->
<section class="py-16 lg:py-24 bg-white" x-data="{ previewUrl: '', previewTitle: '', showPreview: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($reports->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($reports as $report)
                    <article class="group bg-gray-300 rounded-2xl overflow-hidden border border-gray-300 shadow-sm card-hover flex flex-col">
                        <!-- Thumbnail -->
                        <div class="block aspect-[16/10] bg-gradient-to-br from-pema-50 to-blue-50 relative overflow-hidden flex-shrink-0">
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-2xl bg-pema-100 flex items-center justify-center mb-3">
                                    <i class="fi fi-rs-file-pdf text-pema-400 text-2xl"></i>
                                </div>
                                <p class="text-xs text-pema-300 font-medium">{{ $report->year }}</p>
                            </div>
                            @if($report->file)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-pema-500 text-white text-xs font-medium rounded-lg">
                                    <i class="fi fi-rs-download mr-1"></i> Unduh
                                </span>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fi fi-rs-calendar text-xs"></i>
                                    {{ $report->year }}
                                </span>
                            </div>
                            <h3 class="font-heading font-semibold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-pema-500 transition-colors">
                                {{ $report->title }}
                            </h3>
                            @if($report->description)
                                <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4">
                                    {{ $report->description }}
                                </p>
                            @else
                                <p class="text-gray-400 text-sm italic mb-4">Tidak ada deskripsi</p>
                            @endif
                            @if($report->file)
                                <div class="flex items-center gap-3 mt-auto pt-4">
                                    <button 
                                        @click="previewUrl = '{{ route('laporan.view', $report) }}'; previewTitle = '{{ addslashes($report->title) }}'; showPreview = true"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-pema-50 hover:bg-pema-100 text-pema-600 font-medium text-sm rounded-xl transition-colors">
                                        <i class="fi fi-rs-eye text-sm"></i>
                                        Preview
                                    </button>
                                    <a href="{{ route('laporan.download', $report) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 font-medium text-sm transition-colors group/link">
                                        Unduh
                                        <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reports->hasPages())
                <div class="mt-12">
                    {{ $reports->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fi fi-rs-file-chart-pie text-gray-300 text-4xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-xl text-gray-900 mb-2">Belum Ada Laporan</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    Belum ada laporan yang tersedia untuk diunduh. Silakan kunjungi halaman ini kembali di lain waktu.
                </p>
            </div>
        @endif
    </div>

    <!-- PDF Preview Modal -->
    <div x-show="showPreview" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 pdf-viewer-modal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="showPreview = false">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80" @click="showPreview = false"></div>
        
        <!-- Modal Content -->
        <div class="relative w-full h-full max-w-6xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center">
                        <i class="fi fi-rs-file-pdf text-gray-500"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-semibold text-gray-900 text-sm" x-text="previewTitle"></h3>
                        <p class="text-xs text-gray-400">PDF Document</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a :href="previewUrl.replace('/view/', '/download/')" target="_blank"
                       class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors inline-flex items-center gap-2">
                        <i class="fi fi-rs-download text-sm"></i>
                        Unduh
                    </a>
                    <button @click="showPreview = false"
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- PDF Viewer -->
            <div class="pdf-container">
                <iframe :src="previewUrl" x-show="showPreview"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection
