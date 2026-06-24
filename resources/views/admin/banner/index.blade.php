@extends('admin.layouts.master')

@section('title', 'Banner Halaman Depan')
@section('page_title', 'Banner Halaman Depan')

@section('content')
<div x-data="{ deleteUrl: '' }" x-on:confirm-action.window="
    if($event.detail.id==='delete-confirm') { const f=document.createElement('form'); f.method='POST'; f.action=deleteUrl; const t=document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'); f.innerHTML='<input type=\'hidden\' name=\'_token\' value=\''+t+'\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'>'; document.body.appendChild(f); f.submit(); }
">
    <x-admin.confirm-modal id="delete-confirm" title="Hapus Banner" message="Apakah Anda yakin ingin menghapus banner ini?" confirmText="Ya, Hapus" variant="danger" />
    
    <div class="flex items-center justify-between mb-5">
        <p class="text-sm text-gray-500">Kelola gambar poster/slider di halaman beranda.</p>
        <a href="{{ route('admin.banner.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm">
            <i class="fi fi-rs-plus text-sm"></i>
            Tambah Banner
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="mb-5">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari judul banner..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all">
            </div>
            <select name="filter"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white">
                <option value="">Semua Status</option>
                <option value="active" {{ request('filter') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('filter') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="submit" class="px-4 py-2.5 bg-pema-500 text-white text-sm font-medium rounded-xl hover:bg-pema-600 transition-colors">
                <i class="fi fi-rs-search text-sm"></i>
            </button>
            @if(request('search') || request('filter'))
                <a href="{{ url()->current() }}" class="px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                    <i class="fi fi-rs-cross text-sm"></i>
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Gambar</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Judul</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Urutan</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                    <th class="text-right px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($banners as $banner)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                    <td class="px-5 py-3">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}" class="w-16 h-16 object-contain bg-gray-50 rounded-lg border border-gray-100">
                    </td>
                    <td class="px-5 py-3 font-medium text-gray-900">{{ $banner->title ?? '-' }}</td>
                    <td class="px-5 py-3 text-gray-400">{{ $banner->sort_order }}</td>
                    <td class="px-5 py-3 text-center">
                        @if($banner->is_active)
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg"><i class="fi fi-rs-check-circle text-xs"></i> Aktif</span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-lg"><i class="fi fi-rs-circle text-xs"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.banner.edit', $banner) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium">
                            <i class="fi fi-rs-edit"></i>
                            Edit
                        </a>
                        <button type="button"
                                x-on:click="deleteUrl = '{{ route('admin.banner.destroy', $banner) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                            <i class="fi fi-rs-trash"></i>
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                        @if(request('search') || request('filter'))
                            <i class="fi fi-rs-search text-gray-300 text-4xl mb-3 inline-block"></i>
                            <p class="text-gray-500 text-sm">Tidak ditemukan banner yang sesuai.</p>
                            <a href="{{ url()->current() }}" class="text-pema-500 text-sm font-medium hover:underline mt-1 inline-block">Reset filter</a>
                        @else
                            <i class="fi fi-rs-images text-gray-300 text-4xl mb-3 inline-block"></i>
                            <p class="text-gray-500 text-sm">Belum ada banner.</p>
                            <a href="{{ route('admin.banner.create') }}" class="text-pema-500 text-sm font-medium hover:underline mt-1 inline-block">Tambah banner baru</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($banners->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $banners->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
