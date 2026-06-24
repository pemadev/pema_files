@extends('admin.layouts.master')

@section('title', 'Pengumuman')
@section('page_title', 'Pengumuman')

@section('content')
<div class="space-y-6" x-data="{ deleteUrl: '' }" x-on:confirm-action.window="
    if($event.detail.id==='delete-confirm') { const f=document.createElement('form'); f.method='POST'; f.action=deleteUrl; const t=document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'); f.innerHTML='<input type=\'hidden\' name=\'_token\' value=\''+t+'\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'>'; document.body.appendChild(f); f.submit(); }
">
    <x-admin.confirm-modal
        id="delete-confirm"
        title="Hapus Pengumuman"
        message="Apakah Anda yakin ingin menghapus pengumuman ini? Data yang sudah dihapus tidak dapat dikembalikan."
        confirmText="Ya, Hapus"
        variant="danger"
    />
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-heading font-semibold text-gray-900">Daftar Pengumuman</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola pengumuman perusahaan</p>
        </div>
        <a href="{{ route('admin.pengumuman.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-pema-500 text-white rounded-xl hover:bg-pema-600 transition-all text-sm font-medium shadow-sm">
            <i class="fi fi-rs-plus"></i>
            Tambah Pengumuman
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="mb-5">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari judul pengumuman..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all">
            </div>
            <select name="filter"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white">
                <option value="">Semua</option>
                <option value="published" {{ request('filter') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('filter') === 'draft' ? 'selected' : '' }}>Draft</option>
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

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3.5 font-heading font-semibold text-gray-600 text-xs uppercase tracking-wider">Judul</th>
                        <th class="text-left px-5 py-3.5 font-heading font-semibold text-gray-600 text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-5 py-3.5 font-heading font-semibold text-gray-600 text-xs uppercase tracking-wider">Penulis</th>
                        <th class="text-center px-5 py-3.5 font-heading font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                        <th class="text-right px-5 py-3.5 font-heading font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($newsList as $news)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    @if($news->image)
                                        <img src="{{ asset('storage/' . $news->image) }}"
                                             alt="{{ $news->title }}"
                                             class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fi fi-rs-megaphone text-amber-500"></i>
                                        </div>
                                    @endif
                                    <span class="font-medium text-gray-900 truncate max-w-xs">{{ $news->title }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-gray-500 whitespace-nowrap">
                                {{ $news->date->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4 text-gray-500 whitespace-nowrap">
                                {{ $news->author }}
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                @if($news->is_published)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-medium">
                                        <i class="fi fi-rs-check-circle text-xs"></i>
                                        Publik
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 text-gray-500 rounded-lg text-xs font-medium">
                                        <i class="fi fi-rs-eye-crossed text-xs"></i>
                                        Draf
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                     <a href="{{ route('admin.pengumuman.edit', $news) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium">
                                         <i class="fi fi-rs-edit"></i>
                                         Edit
                                     </a>
                                    <button type="button"
                                            x-on:click="deleteUrl = '{{ route('admin.pengumuman.destroy', $news) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-all text-xs font-medium">
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
                                    <i class="fi fi-rs-megaphone text-4xl text-gray-300"></i>
                                    <p class="text-gray-400 text-sm">Belum ada pengumuman.</p>
                                    <a href="{{ route('admin.pengumuman.create') }}"
                                       class="text-pema-500 hover:text-pema-600 text-sm font-medium">
                                        Tambah pengumuman pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($newsList->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $newsList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
