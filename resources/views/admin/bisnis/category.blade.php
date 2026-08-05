@extends('admin.layouts.master')

@php
    $catLabels = ['migas' => 'Migas', 'agroindustri' => 'Agroindustri', 'jasa' => 'Jasa & Perdagangan'];
    $catIcons = ['migas' => 'fi fi-rs-gas-pump', 'agroindustri' => 'fi fi-rs-leaf', 'jasa' => 'fi fi-rs-handshake'];
    $catBg = ['migas' => 'bg-blue-50 text-blue-600', 'agroindustri' => 'bg-green-50 text-green-600', 'jasa' => 'bg-gold-50 text-amber-600'];
@endphp

@section('title', $catLabels[$category] ?? 'Bidang Bisnis')
@section('page_title', $catLabels[$category] ?? 'Bidang Bisnis')

@section('content')
<div class="space-y-6" x-data="{ deleteUrl: '' }" x-on:confirm-action.window="
    if($event.detail.id==='delete-confirm') { const f=document.createElement('form'); f.method='POST'; f.action=deleteUrl; const t=document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'); f.innerHTML='<input type=\'hidden\' name=\'_token\' value=\''+t+'\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'>'; document.body.appendChild(f); f.submit(); }
">
    <x-admin.confirm-modal id="delete-confirm" title="Hapus Bisnis" message="Apakah Anda yakin ingin menghapus data bisnis ini?" confirmText="Ya, Hapus" variant="danger" />

    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.bisnis.index') }}" class="p-2 rounded-lg text-gray-400 hover:text-pema-500 hover:bg-pema-50 transition-all">
                <i class="fi fi-rs-arrow-left text-lg"></i>
            </a>
            <div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">{{ $catLabels[$category] ?? 'Bidang Bisnis' }}</h3>
                <p class="text-xs text-gray-400">{{ $items->total() }} item</p>
            </div>
        </div>
        <a href="{{ route('admin.bisnis.create') }}?category={{ $category }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-all shadow-sm">
            <i class="fi fi-rs-plus text-sm"></i> Tambah
        </a>
    </div>

    <div>
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3">
            <input type="hidden" name="category" value="{{ $category }}">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                <i class="fi fi-rs-search text-sm"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.bisnis.index', ['category' => $category]) }}" class="px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                    <i class="fi fi-rs-cross text-sm"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3.5 font-heading font-semibold text-gray-600 text-xs uppercase tracking-wider">Judul</th>
                        <th class="text-left px-5 py-3.5 font-heading font-semibold text-gray-600 text-xs uppercase tracking-wider">Deskripsi</th>
                        <th class="text-center px-5 py-3.5 font-heading font-semibold text-gray-600 text-xs uppercase tracking-wider">Urutan</th>
                        <th class="text-right px-5 py-3.5 font-heading font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $business)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    @if($business->images)
                                        @php $firstImg = trim(explode(',', $business->images)[0]); @endphp
                                        @if($firstImg)
                                            <img src="{{ asset('storage/' . $firstImg) }}"
                                                 alt="{{ $business->title }}"
                                                 class="w-10 h-10 rounded-lg object-contain flex-shrink-0 bg-gray-50">
                                        @else
                                            <div class="w-10 h-10 {{ $catBg[$category] ?? 'bg-gray-100' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i class="{{ $catIcons[$category] ?? 'fi fi-rs-briefcase' }} text-lg"></i>
                                            </div>
                                        @endif
                                    @elseif($business->image)
                                        <img src="{{ asset('storage/' . $business->image) }}"
                                             alt="{{ $business->title }}"
                                             class="w-10 h-10 rounded-lg object-contain flex-shrink-0 bg-gray-50">
                                    @else
                                        <div class="w-10 h-10 {{ $catBg[$category] ?? 'bg-gray-100' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="{{ $catIcons[$category] ?? 'fi fi-rs-briefcase' }} text-lg"></i>
                                        </div>
                                    @endif
                                    <span class="font-medium text-gray-900 truncate max-w-xs">{{ $business->title }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-gray-500 max-w-xs">
                                <span class="line-clamp-1">{{ Str::limit(strip_tags($business->description), 80) }}</span>
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-50 font-medium text-gray-500 text-xs">{{ ($business->sort_order ?? 0) + 1 }}</span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.bisnis.edit', $business) }}?category={{ $business->category }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium">
                                        <i class="fi fi-rs-edit"></i> Edit
                                    </a>
                                    <button type="button"
                                            x-on:click="deleteUrl = '{{ route('admin.bisnis.destroy', $business) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        <i class="fi fi-rs-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="{{ $catIcons[$category] ?? 'fi fi-rs-briefcase' }} text-4xl text-gray-300"></i>
                                    <p class="text-gray-400 text-sm">Belum ada data {{ strtolower($catLabels[$category] ?? 'bisnis') }}.</p>
                                    <a href="{{ route('admin.bisnis.create') }}?category={{ $category }}"
                                       class="text-pema-500 hover:text-pema-600 text-sm font-medium">
                                        Tambah sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
