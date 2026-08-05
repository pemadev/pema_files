@extends('admin.layouts.master')

@section('title', 'Bidang Bisnis')
@section('page_title', 'Bidang Bisnis')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Pilih kategori bidang bisnis untuk mulai mengelola.</p>
        <a href="{{ route('admin.bisnis.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-all shadow-sm">
            <i class="fi fi-rs-plus text-sm"></i>
            Tambah Bisnis
        </a>
    </div>

    @php
        $categories = [
            'migas' => ['label' => 'Migas', 'icon' => 'fi fi-rs-gas-pump', 'desc' => 'Minyak & Gas Bumi', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'count' => isset($businesses['migas']) ? $businesses['migas']->count() : 0],
            'agroindustri' => ['label' => 'Agroindustri', 'icon' => 'fi fi-rs-leaf', 'desc' => 'Perkebunan & Perikanan', 'bg' => 'bg-green-50', 'text' => 'text-green-600', 'count' => isset($businesses['agroindustri']) ? $businesses['agroindustri']->count() : 0],
            'jasa' => ['label' => 'Jasa & Perdagangan', 'icon' => 'fi fi-rs-handshake', 'desc' => 'Jasa & Perdagangan', 'bg' => 'bg-gold-50', 'text' => 'text-amber-600', 'count' => isset($businesses['jasa']) ? $businesses['jasa']->count() : 0],
        ];
    @endphp

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $key => $cat)
            <a href="{{ route('admin.bisnis.index', ['category' => $key]) }}"
               class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 hover:shadow-lg hover:border-pema-200 transition-all duration-300 group">
                <div class="w-14 h-14 rounded-2xl {{ $cat['bg'] }} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="{{ $cat['icon'] }} {{ $cat['text'] }} text-2xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-lg text-gray-900 mb-1">{{ $cat['label'] }}</h3>
                <p class="text-sm text-gray-400 mb-4">{{ $cat['desc'] }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg">{{ $cat['count'] }} item</span>
                    <span class="text-pema-500 text-sm font-medium group-hover:gap-3 inline-flex items-center gap-2 transition-all">
                        Kelola <span class="inline-flex items-center"><i class="fi fi-rs-arrow-right text-sm"></i></span>
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
