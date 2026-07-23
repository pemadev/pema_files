@extends('layouts.app')

@section('title', $team->name . ' - PT PEMA')

@section('content')
<section class="py-20 lg:py-28 bg-gray-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 font-medium text-sm mb-8">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>

        <div class="grid md:grid-cols-3 gap-10 items-start">
            <div class="md:col-span-1">
                <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm aspect-[3/4] bg-gray-50">
                    @if($team->photo)
                        <img src="{{ Storage::url($team->photo) }}" alt="{{ $team->name }}" class="w-full h-full object-contain bg-gray-50">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fi fi-rs-user text-pema-300 text-5xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="md:col-span-2">
                <span class="text-gold-500 font-semibold text-sm uppercase tracking-widest">
                    {{ $team->category === 'direksi' ? 'Dewan Direksi' : 'Dewan Komisaris' }}
                </span>
                <h1 class="text-3xl font-heading font-bold text-gray-900 mt-2">{{ $team->name }}</h1>
                <p class="text-pema-500 font-medium mt-1 mb-6">{{ $team->position }}</p>
                <div class="w-16 h-0.5 bg-gold-500 mb-6"></div>

                @if($team->biography)
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        {!! nl2br(e($team->biography)) !!}
                    </div>
                @else
                    <p class="text-gray-400 italic">Biografi belum tersedia.</p>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection