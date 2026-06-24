@extends('layouts.app')

@section('title', '503 - Pemeliharaan | PT PEMA')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-lg mx-auto">
        <div class="text-[10rem] sm:text-[12rem] font-extrabold leading-none tracking-tight text-pema-500 select-none font-heading">
            503
        </div>

        <h1 class="mt-4 text-3xl sm:text-4xl font-bold text-gray-900 font-heading">
            Sedang Pemeliharaan
        </h1>

        <p class="mt-4 text-lg text-gray-500 leading-relaxed font-sans">
            Website sedang dalam pemeliharaan.<br class="hidden sm:inline">
            Silakan kembali lagi dalam beberapa saat.
        </p>

        <div class="mt-8">
            <a href="{{ route('beranda') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-pema-500 text-white font-semibold rounded-xl shadow-md hover:bg-pema-600 focus:outline-none focus:ring-2 focus:ring-pema-400 focus:ring-offset-2 transition-all duration-200 font-sans">
                <i class="fi fi-rs-home mr-1"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
