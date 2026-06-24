@extends('admin.layouts.master')

@section('title', 'Galeri Foto')
@section('page_title', 'Galeri Foto')

@section('content')
<div class="space-y-6" x-data="{ deleteUrl: '' }" x-on:confirm-action.window="
    if($event.detail.id==='delete-confirm') { const f=document.createElement('form'); f.method='POST'; f.action=deleteUrl; const t=document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'); f.innerHTML='<input type=\'hidden\' name=\'_token\' value=\''+t+'\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'>'; document.body.appendChild(f); f.submit(); }
">
    <x-admin.confirm-modal
        id="delete-confirm"
        title="Hapus Galeri"
        message="Apakah Anda yakin ingin menghapus galeri ini? Data yang sudah dihapus tidak dapat dikembalikan."
        confirmText="Ya, Hapus"
        variant="danger"
    />
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-gray-500">Kelola galeri foto perusahaan</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}"
           class="inline-flex items-center gap-2 bg-pema-500 text-white px-5 py-2.5 rounded-xl hover:bg-pema-600 transition-all text-sm font-medium shadow-sm">
            <i class="fi fi-rs-plus text-base"></i>
            Tambah Galeri
        </a>
    </div>

    {{-- Search --}}
    <div class="mb-5">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari judul galeri..." value="{{ request('search') }}"
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

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                        <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3.5 text-left">Judul</th>
                        <th class="px-5 py-3.5 text-left">Gambar</th>
                        <th class="px-5 py-3.5 text-left">Caption</th>
                        <th class="px-5 py-3.5 text-center w-20">Urutan</th>
                        <th class="px-5 py-3.5 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($galleries as $gallery)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">
                                <span class="font-medium text-gray-900">{{ $gallery->title }}</span>
                            </td>
                            <td class="px-5 py-4">
                                @php $firstImg = trim(explode(',', $gallery->image)[0]); @endphp
                                @if($firstImg)
                                <img src="{{ asset('storage/' . $firstImg) }}"
                                     alt="{{ $gallery->title }}"
                                     class="w-20 h-14 object-contain bg-gray-50 rounded-lg border border-gray-100"
                                     onerror="this.onerror=null;this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%23d1d5db%22><path d=%22M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l2.409-2.409a2.25 2.25 0 013.182 0l2.409 2.409m-3-3.75a3 3 0 11-6 0 3 3 0 016 0z%22/></svg>'">
                                @else
                                <div class="w-20 h-14 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l2.409-2.409a2.25 2.25 0 013.182 0l2.409 2.409m-3-3.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-500 max-w-xs truncate">
                                {{ $gallery->caption ?: '-' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-sm font-medium text-gray-600">
                                    {{ ($gallery->sort_order ?? 0) + 1 }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                     <a href="{{ route('admin.galeri.edit', $gallery) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium">
                                         <i class="fi fi-rs-edit"></i>
                                         Edit
                                     </a>
                                    <button type="button"
                                            x-on:click="deleteUrl = '{{ route('admin.galeri.destroy', $gallery) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        <i class="fi fi-rs-trash"></i>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center">
                                        <i class="fi fi-rs-images text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-sm text-gray-400">Belum ada data galeri.</p>
                                    <a href="{{ route('admin.galeri.create') }}"
                                       class="text-pema-500 hover:text-pema-600 text-sm font-medium">
                                        Tambah galeri sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($galleries->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
