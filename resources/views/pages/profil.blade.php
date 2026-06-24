@extends('layouts.app')

@section('title', 'Profil Perusahaan - PT PEMA')
@section('meta_description', 'Profil PT Pembangunan Aceh (PEMA) - Sambutan Direktur Utama, Sejarah Perusahaan, Visi dan Misi, serta Informasi Stakeholder.')

@section('content')
<!-- Page Header -->
<section class="relative pt-20 pb-16 lg:pb-20 bg-pema-800 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-pema-400/20 rounded-full blur-3xl"></div>
    </div>
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
        <div class="max-w-3xl">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-gold-400 text-sm font-medium">
                    Profil Perusahaan
                </span>
            </div>
            <h1 class="animate-fade-in-up delay-100 text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-white mt-4 mb-4">
                Profil <span class="gradient-gold">PT PEMA</span>
            </h1>
            <p class="animate-fade-in-up delay-200 text-gray-300 text-lg max-w-2xl">
                Mengenal lebih dekat PT Pembangunan Aceh (PEMA) — Badan Usaha Milik Daerah yang berkomitmen memajukan perekonomian Aceh.
            </p>
        </div>
    </div>
</section>

<!-- Visi dan Misi -->
@if($visiMisi && ($visiMisi->title || $visiMisi->content))
@php
    $visiText = $visiMisi->title ?? '';
    $misiText = $visiMisi->content ?? '';
    $misiItems = array_filter(explode("\n", $misiText), fn($line) => trim($line));
@endphp
<section id="visi-misi" class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Visi & Misi</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                {{ $visiMisi->title ?? 'Visi dan Misi Perusahaan' }}
            </h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto"></div>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Visi -->
            @if($visiText)
            <div class="bg-gradient-to-br from-pema-500 to-pema-600 rounded-2xl p-8 lg:p-10 text-white animate-slide-in-left">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mb-6">
                    <i class="fi fi-rs-flag text-white text-2xl"></i>
                </div>
                <h3 class="font-heading font-bold text-2xl mb-4">Visi</h3>
                <p class="text-white leading-relaxed text-lg">{!! $visiText !!}</p>
            </div>
            @endif

            <!-- Misi -->
            @if(count($misiItems) > 0)
            <div class="bg-gradient-to-br from-gold-500 to-gold-600 rounded-2xl p-8 lg:p-10 text-white animate-slide-in-right">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mb-6">
                    <i class="fi fi-rs-bullseye text-white text-2xl"></i>
                </div>
                <h3 class="font-heading font-bold text-2xl mb-4">Misi</h3>
                <ul class="space-y-4">
                    @foreach($misiItems as $misi)
                        @if(trim($misi))
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-white rounded-full mt-2 flex-shrink-0"></span>
                            <span class="text-white/90 leading-relaxed">{{ trim($misi) }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Sambutan Dirut -->
@if($sambutan && $sambutan->title)
<section id="sambutan" class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-5 gap-12 items-start">
            <div class="lg:col-span-2 animate-slide-in-left">
                <div class="relative">
                    <div class="aspect-[3/4] bg-gray-100 rounded-2xl overflow-hidden relative py-4">
                        @if($sambutan->image)
                            <img src="{{ asset('storage/' . $sambutan->image) }}"
                                 alt="{{ $sambutan->title ?? 'Foto Direktur Utama' }}"
                                 class="w-full h-full object-contain rounded-xl bg-gray-50">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-pema-500/10 to-pema-700/20"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fi fi-rs-user text-gray-300 text-6xl"></i>
                            </div>
                        @endif
                    </div>
                    <!-- Frame decoration -->
                    <div class="absolute -bottom-4 -right-4 w-full h-full border-2 border-gold-500/20 rounded-2xl -z-10"></div>
                </div>
            </div>
            <div class="lg:col-span-3 animate-slide-in-right">
                <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Sambutan</span>
                <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-2">Direktur Utama</h2>
                <div class="w-16 h-1 bg-gold-500 rounded-full mb-8"></div>

                @if($sambutan->additional_info)
                <div class="text-gray-600 leading-relaxed">
                    <p>
                        <i class="fi fi-rs-quote-right text-gold-500 text-2xl inline-block mb-2 opacity-50"></i>
                    </p>
                    <p class="text-lg italic leading-relaxed">{!! $sambutan->additional_info !!}</p>
                </div>
                @endif

                <div class="mt-8 pt-8 border-t border-gray-100">
                    @if($sambutan->title)
                    <p class="font-heading font-semibold text-gray-900 text-lg">{{ $sambutan->title }}</p>
                    @endif
                    @if($sambutan->content)
                    <p class="text-gold-500 font-medium">{!! html_entity_decode($sambutan->content) !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Sejarah -->
@if($sejarah && $sejarah->content)
@php
    $timelineItems = array_filter(explode("\n\n", $sejarah->content), fn($item) => trim($item));
@endphp
@if(count($timelineItems) > 0)
<section id="sejarah" class="py-20 lg:py-28 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Sejarah</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                {{ $sejarah->title ?? 'Sejarah PT PEMA' }}
            </h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto"></div>
        </div>

            <div class="max-w-4xl mx-auto">
                @foreach($timelineItems as $index => $item)
                    @php
                        $lines = explode("\n", trim($item));
                        $year = '';
                        $title = '';
                        $description = '';

                        if (count($lines) >= 2) {
                            $year = trim($lines[0]);
                            $title = trim($lines[1] ?? '');
                            $descriptionLines = array_slice($lines, 2);
                            $description = implode("\n", $descriptionLines);
                        } else {
                            $description = trim($lines[0] ?? '');
                        }

                        $isHighlight = $loop->last;
                    @endphp
                    <div class="flex gap-5 pb-10">
                        <div class="flex-1 min-w-0 pb-5">
                            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm {{ $isHighlight ? 'ring-1 ring-gold-500/20' : '' }}">
                                @if($year)
                                <span class="text-gold-500 font-bold text-sm">{{ $year }}</span>
                                @endif
                                @if($title)
                                <h3 class="font-heading font-semibold text-xl text-gray-900 mt-2 mb-3">{{ $title }}</h3>
                                @endif
                                @if($description)
                                <p class="text-gray-600 leading-relaxed">{!! nl2br(trim($description)) !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
</section>
@endif
@endif


<!-- Stakeholder -->
@if($stakeholder && $stakeholder->content)
<section id="stakeholder" class="py-20 lg:py-28 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Stakeholder</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">
                {{ $stakeholder->title ?? 'Stakeholder' }}
            </h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto"></div>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl p-8 lg:p-10 border border-gray-100 shadow-sm">
                <div class="text-gray-600 leading-relaxed space-y-5">
                    @foreach(explode("\n\n", $stakeholder->content) as $paragraph)
                        @if(trim($paragraph))
                        <p>{!! trim($paragraph) !!}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Team: Direksi -->
@if($direksi && $direksi->count() > 0)
<section id="direksi" class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Manajemen</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">Dewan Direksi</h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto"></div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 max-w-6xl mx-auto">
            @foreach($direksi as $member)
            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col">
                <div class="aspect-[3/4] bg-gray-50 relative overflow-hidden flex-shrink-0">
                    @if($member->photo)
                        <img src="{{ Storage::url($member->photo) }}"
                             alt="{{ $member->name }}"
                             loading="lazy"
                             class="w-full h-full object-contain bg-gray-50 group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-pema-500/5 to-pema-700/10"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-20 h-20 bg-pema-100 rounded-full flex items-center justify-center">
                                <i class="fi fi-rs-user text-pema-300 text-3xl"></i>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="font-heading font-semibold text-gray-900">{{ $member->name }}</h3>
                    @if($member->position)
                    <p class="text-gold-500 text-sm mt-auto pt-2">{{ $member->position }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Team: Komisaris -->
@if($komisaris && $komisaris->count() > 0)
<section id="komisaris" class="py-20 lg:py-28 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">Pengawasan</span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-900 mt-3 mb-4">Dewan Komisaris</h2>
            <div class="w-16 h-1 bg-gold-500 rounded-full mx-auto"></div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 max-w-6xl mx-auto">
            @foreach($komisaris as $member)
            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col">
                <div class="aspect-[3/4] bg-gray-50 relative overflow-hidden flex-shrink-0">
                    @if($member->photo)
                        <img src="{{ Storage::url($member->photo) }}"
                             alt="{{ $member->name }}"
                             loading="lazy"
                             class="w-full h-full object-contain bg-gray-50 group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-pema-500/5 to-pema-700/10"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-20 h-20 bg-pema-100 rounded-full flex items-center justify-center">
                                <i class="fi fi-rs-user text-pema-300 text-3xl"></i>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="font-heading font-semibold text-gray-900">{{ $member->name }}</h3>
                    @if($member->position)
                    <p class="text-gold-500 text-sm mt-auto pt-2">{{ $member->position }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Empty state when no data at all -->
@unless($sambutan || $sejarah || $visiMisi || $stakeholder || ($direksi && $direksi->count() > 0) || ($komisaris && $komisaris->count() > 0))
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-lg mx-auto">
            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fi fi-rs-info text-gray-400 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-heading font-bold text-gray-900 mb-2">Belum Ada Data</h2>
            <p class="text-gray-500">Informasi profil perusahaan belum tersedia. Silakan kembali lagi nanti.</p>
        </div>
    </div>
</section>
@endunless
@endsection
