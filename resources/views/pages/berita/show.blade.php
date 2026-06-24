@extends('layouts.app')

@section('title', $news->title . ' - PT PEMA')
@section('meta_description', Str::limit(strip_tags($news->content), 160))
@section('og_title', $news->title)
@section('og_description', Str::limit(strip_tags($news->content), 160))

@push('styles')
<style>
.article-content h2,
.article-content h3,
.article-content h4 {
    @apply font-heading font-bold text-gray-900 mt-8 mb-4;
}
.article-content h2 { @apply text-2xl; }
.article-content h3 { @apply text-xl; }
.article-content h4 { @apply text-lg; }

.article-content p {
    @apply text-gray-600 leading-relaxed mb-4;
}

.article-content ul,
.article-content ol {
    @apply text-gray-600 leading-relaxed mb-4 pl-6;
}
.article-content ul { @apply list-disc; }
.article-content ol { @apply list-decimal; }

.article-content li { @apply mb-2; }

.article-content blockquote {
    @apply border-l-4 border-gold-500 pl-4 italic text-gray-500 my-6;
}

.article-content a {
    @apply text-pema-500 hover:text-pema-600 underline;
}

.article-content img {
    @apply rounded-xl my-6 w-full;
}
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="relative pt-20 pb-12 lg:pb-16 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-80 h-80 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <!-- Breadcrumb / Back -->
        <div class="animate-fade-in-up mb-6">
            <a href="{{ route('berita.index') }}"
               class="inline-flex items-center gap-2 text-gray-300 hover:text-gold-400 text-sm transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                Kembali ke Berita
            </a>
        </div>

        <div class="max-w-4xl">
            <div class="animate-fade-in-up delay-100">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">
                    Berita
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-200 text-3xl sm:text-4xl lg:text-4xl font-heading font-bold text-white mt-4 leading-tight">
                {{ $news->title }}
            </h1>
            <div class="animate-fade-in-up delay-300 flex flex-wrap items-center gap-4 mt-6 text-gray-300 text-sm">
                <span class="flex items-center gap-2">
                    <i class="fi fi-rs-calendar text-gold-400"></i>
                    {{ $news->date instanceof \Carbon\Carbon ? $news->date->format('d M Y') : \Carbon\Carbon::parse($news->date)->format('d M Y') }}
                </span>
                @if($news->author)
                    <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                    <span class="flex items-center gap-2">
                        <i class="fi fi-rs-user text-gold-400"></i>
                        {{ $news->author }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Main Article -->
            <div class="lg:col-span-2">
                @if($news->image)
                    <div class="animate-fade-in-up mb-8">
                        <img src="{{ asset('storage/' . $news->image) }}"
                             alt="{{ $news->title }}"
                             class="w-full aspect-[16/9] object-contain rounded-2xl shadow-sm bg-gray-50">
                    </div>
                @endif

                <article class="animate-fade-in-up delay-100 article-content text-gray-600 leading-relaxed">
                    {!! html_entity_decode($news->content) !!}
                </article>

                <!-- Share Buttons -->
                <div class="animate-fade-in-up delay-200 mt-12 pt-8 border-t border-gray-100">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="text-sm font-medium text-gray-700">Bagikan:</span>
                        <div class="flex items-center gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-10 h-10 bg-blue-50 hover:bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 hover:text-blue-700 transition-colors"
                               aria-label="Bagikan ke Facebook">
                                <i class="fi fi-brands-facebook text-lg"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ urlencode(url()->current()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-10 h-10 bg-sky-50 hover:bg-sky-100 rounded-xl flex items-center justify-center text-sky-600 hover:text-sky-700 transition-colors"
                               aria-label="Bagikan ke Twitter">
                                <i class="fi fi-brands-twitter text-lg"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . url()->current()) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-10 h-10 bg-green-50 hover:bg-green-100 rounded-xl flex items-center justify-center text-green-600 hover:text-green-700 transition-colors"
                               aria-label="Bagikan ke WhatsApp">
                                <i class="fi fi-brands-whatsapp text-lg"></i>
                            </a>
                            <button onclick="navigator.clipboard.writeText(window.location.href).then(() => { this.querySelector('span').textContent = 'Tersalin!'; setTimeout(() => { this.querySelector('span').textContent = 'Salin Link'; }, 2000); })"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm text-gray-600 hover:text-gray-700 transition-colors">
                                <i class="fi fi-rs-link"></i>
                                <span>Salin Link</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Banner Carousel -->
                <div class="animate-fade-in-up delay-150 mb-8">
                    <x-banner-carousel />
                </div>

                <!-- Related News -->
                <div class="animate-fade-in-up delay-200 sticky top-28">
                    <div class="bg-gray-300 rounded-2xl p-6 border border-gray-100">
                        <h3 class="font-heading font-bold text-lg text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fi fi-rs-newspaper text-pema-500"></i>
                            Berita Lainnya
                        </h3>

                        @if($relatedNews->count() > 0)
                            <div class="space-y-5">
                                @foreach($relatedNews as $related)
                                    <a href="{{ route('berita.detail', $related) }}"
                                       class="group flex gap-4 p-3 -mx-3 rounded-xl hover:bg-white transition-colors">
                                        <!-- Thumbnail -->
                                        <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-200 flex-shrink-0">
                                            @if($related->image)
                                                <img src="{{ asset('storage/' . $related->image) }}"
                                                     alt="{{ $related->title }}"
                                                     class="w-full h-full object-contain bg-gray-50">
                                            @else
                                                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l2.409-2.409a2.25 2.25 0 013.182 0l2.409 2.409m-3-3.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Info -->
                                        <div class="flex-1 min-w-0">
                                            <span class="text-xs text-gray-400">
                                                {{ $related->date instanceof \Carbon\Carbon ? $related->date->format('d M Y') : \Carbon\Carbon::parse($related->date)->format('d M Y') }}
                                            </span>
                                            @if($related->author)
                                                <div class="text-xs text-gray-400 mt-0.5">{{ $related->author }}</div>
                                            @endif
                                            <h4 class="font-heading font-medium text-sm text-gray-900 mt-1 line-clamp-2 group-hover:text-pema-500 transition-colors">
                                                {{ $related->title }}
                                            </h4>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 text-sm text-center py-6">Belum ada berita lainnya.</p>
                        @endif

                        <div class="mt-6 pt-5 border-t border-gray-200">
                            <a href="{{ route('berita.index') }}"
                               class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-colors">
                                Lihat Semua Berita
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
