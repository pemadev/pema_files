@extends('admin.layouts.master')

@section('title', 'Mitra Kerja')
@section('page_title', 'Mitra Kerja')

@section('content')
<div class="space-y-6" x-data="{ deleteUrl: '' }" x-on:confirm-action.window="
    if($event.detail.id==='delete-confirm') { const f=document.createElement('form'); f.method='POST'; f.action=deleteUrl; const t=document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'); f.innerHTML='<input type=\'hidden\' name=\'_token\' value=\''+t+'\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'>'; document.body.appendChild(f); f.submit(); }
">
    <x-admin.confirm-modal
        id="delete-confirm"
        title="Hapus Mitra"
        message="Apakah Anda yakin ingin menghapus mitra ini? Data yang sudah dihapus tidak dapat dikembalikan."
        confirmText="Ya, Hapus"
        variant="danger"
    />
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">Kelola mitra kerja sama PT PEMA</p>
        </div>
        <a href="{{ route('admin.mitra.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
            <i class="fi fi-rs-plus text-sm"></i>
            Tambah Mitra
        </a>
    </div>

    <!-- Search -->
    <div class="mb-5">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari mitra..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                <i class="fi fi-rs-search text-sm"></i>
            </button>
            @if(request('search'))
                <a href="{{ url()->current() }}" class="px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                    <i class="fi fi-rs-cross text-sm"></i>
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Partners List -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                <i class="fi fi-rs-handshake text-green-500 text-sm"></i>
            </div>
            <h3 class="font-heading font-semibold text-gray-900 text-sm">Semua Mitra</h3>
            <span class="ml-auto text-xs text-gray-400">{{ $partners->count() }} mitra</span>
        </div>

        <div class="p-5">
            @if($partners->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                                <th class="text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Logo</th>
                                <th class="text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama</th>
                                <th class="text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Website</th>
                                <th class="text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Urutan</th>
                                <th class="text-right py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($partners as $partner)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-3">
                                        @if($partner->logo)
                                            <img src="{{ Storage::url($partner->logo) }}"
                                                 alt="{{ $partner->name }}"
                                                 class="w-10 h-10 rounded-lg object-contain bg-white border border-gray-100">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <i class="fi fi-rs-building text-gray-400 text-sm"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 font-medium text-gray-900">{{ $partner->name }}</td>
                                    <td class="py-3 px-3">
                                        @if($partner->website)
                                            <a href="{{ $partner->website }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="text-pema-500 hover:text-pema-600 hover:underline inline-flex items-center gap-1">
                                                {{ Str::limit($partner->website, 30) }}
                                                <i class="fi fi-rs-external-link text-xs"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-gray-400">{{ $partner->sort_order ?? '-' }}</td>
                                    <td class="py-3 px-3 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                             <a href="{{ route('admin.mitra.edit', $partner) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium">
                                                 <i class="fi fi-rs-edit"></i>
                                                 Edit
                                             </a>
                                            <button type="button"
                                                    x-on:click="deleteUrl = '{{ route('admin.mitra.destroy', $partner) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                                <i class="fi fi-rs-trash"></i>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <i class="fi fi-rs-handshake text-4xl text-gray-300"></i>
                                            <p class="text-gray-400 text-sm">Tidak ada mitra ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($partners->hasPages())
                    <div class="px-5 py-3 border-t border-gray-100">
                        {{ $partners->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fi fi-rs-handshake text-gray-300 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-400">Belum ada mitra kerja.</p>
                    <a href="{{ route('admin.mitra.create') }}" class="text-pema-500 text-sm font-medium hover:underline mt-1 inline-block">
                        Tambah mitra baru
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
