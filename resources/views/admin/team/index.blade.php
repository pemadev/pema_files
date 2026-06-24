@extends('admin.layouts.master')

@section('title', 'Direksi & Komisaris')
@section('page_title', 'Direksi & Komisaris')

@section('content')
<div class="space-y-6" x-data="{ deleteUrl: '' }" x-on:confirm-action.window="
    if($event.detail.id==='delete-confirm') { const f=document.createElement('form'); f.method='POST'; f.action=deleteUrl; const t=document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'); f.innerHTML='<input type=\'hidden\' name=\'_token\' value=\''+t+'\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'>'; document.body.appendChild(f); f.submit(); }
">
    <x-admin.confirm-modal
        id="delete-confirm"
        title="Hapus Anggota"
        message="Apakah Anda yakin ingin menghapus anggota ini? Data yang sudah dihapus tidak dapat dikembalikan."
        confirmText="Ya, Hapus"
        variant="danger"
    />
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">Kelola anggota Direksi dan Komisaris PT PEMA</p>
        </div>
        <a href="{{ route('admin.team.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
            <i class="fi fi-rs-plus text-sm"></i>
            Tambah Anggota
        </a>
    </div>

    {{-- Search & Filter --}}
    <div class="mb-5">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari nama..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all">
            </div>
            <select name="filter"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white">
                <option value="">Semua</option>
                <option value="direksi" {{ request('filter') === 'direksi' ? 'selected' : '' }}>Direksi</option>
                <option value="komisaris" {{ request('filter') === 'komisaris' ? 'selected' : '' }}>Komisaris</option>
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

    <!-- Team Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                <i class="fi fi-rs-users text-pema-500 text-sm"></i>
            </div>
            <h3 class="font-heading font-semibold text-gray-900 text-sm">Semua Anggota</h3>
            <span class="ml-auto text-xs text-gray-400">{{ $teams->count() }} anggota</span>
        </div>

        <div class="p-5">
            @if($teams->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                                <th class="text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Foto</th>
                                <th class="text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('sort_by', 'sort_dir', 'page'), ['sort_by' => 'name', 'sort_dir' => request('sort_by') === 'name' && request('sort_dir') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-pema-500 transition-colors inline-flex items-center gap-1.5">
                                        Nama
                                        @if(request('sort_by') === 'name')
                                            <i class="fi {{ request('sort_dir') === 'asc' ? 'fi-rs-arrow-small-up' : 'fi-rs-arrow-small-down' }} text-pema-500 text-xs"></i>
                                        @else
                                            <i class="fi fi-rs-arrows-h text-gray-300 text-xs"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('sort_by', 'sort_dir', 'page'), ['sort_by' => 'position', 'sort_dir' => request('sort_by') === 'position' && request('sort_dir') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-pema-500 transition-colors inline-flex items-center gap-1.5">
                                        Jabatan
                                        @if(request('sort_by') === 'position')
                                            <i class="fi {{ request('sort_dir') === 'asc' ? 'fi-rs-arrow-small-up' : 'fi-rs-arrow-small-down' }} text-pema-500 text-xs"></i>
                                        @else
                                            <i class="fi fi-rs-arrows-h text-gray-300 text-xs"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('sort_by', 'sort_dir', 'page'), ['sort_by' => 'category', 'sort_dir' => request('sort_by') === 'category' && request('sort_dir') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-pema-500 transition-colors inline-flex items-center gap-1.5">
                                        Tipe
                                        @if(request('sort_by') === 'category')
                                            <i class="fi {{ request('sort_dir') === 'asc' ? 'fi-rs-arrow-small-up' : 'fi-rs-arrow-small-down' }} text-pema-500 text-xs"></i>
                                        @else
                                            <i class="fi fi-rs-arrows-h text-gray-300 text-xs"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('sort_by', 'sort_dir', 'page'), ['sort_by' => 'sort_order', 'sort_dir' => request('sort_by') === 'sort_order' && request('sort_dir') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-pema-500 transition-colors inline-flex items-center gap-1.5">
                                        Urutan
                                        @if(request('sort_by') === 'sort_order')
                                            <i class="fi {{ request('sort_dir') === 'asc' ? 'fi-rs-arrow-small-up' : 'fi-rs-arrow-small-down' }} text-pema-500 text-xs"></i>
                                        @else
                                            <i class="fi fi-rs-arrows-h text-gray-300 text-xs"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-right py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teams as $member)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-3">
                                        @if($member->photo)
                                            <img src="{{ Storage::url($member->photo) }}"
                                                 alt="{{ $member->name }}"
                                                 class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <i class="fi fi-rs-user text-gray-400 text-sm"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 font-medium text-gray-900">{{ $member->name }}</td>
                                    <td class="py-3 px-3 text-gray-500">{{ $member->position }}</td>
                                    <td class="py-3 px-3">
                                        @php
                                            $type = $member->category ?? (str_contains(strtolower($member->position), 'komisaris') ? 'komisaris' : 'direksi');
                                        @endphp
                                        @if($type === 'komisaris')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-gold-50 text-gold-600 rounded-lg">
                                                <i class="fi fi-rs-badge-check text-xs"></i>
                                                Komisaris
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-pema-50 text-pema-600 rounded-lg">
                                                <i class="fi fi-rs-user-tie text-xs"></i>
                                                Direksi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-gray-400">{{ $member->sort_order ?? '-' }}</td>
                                    <td class="py-3 px-3 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                             <a href="{{ route('admin.team.edit', $member) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium">
                                                 <i class="fi fi-rs-edit"></i>
                                                 Edit
                                             </a>
                                            <button type="button"
                                                    x-on:click="deleteUrl = '{{ route('admin.team.destroy', $member) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                                <i class="fi fi-rs-trash"></i>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto">
                                                <i class="fi fi-rs-users text-gray-300 text-2xl"></i>
                                            </div>
                                            <p class="text-sm text-gray-400">Belum ada anggota.</p>
                                            <a href="{{ route('admin.team.create') }}" class="text-pema-500 text-sm font-medium hover:underline mt-1 inline-block">
                                                Tambah sekarang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($teams->hasPages())
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        {{ $teams->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fi fi-rs-users text-gray-300 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-400">Belum ada anggota.</p>
                    <a href="{{ route('admin.team.create') }}" class="text-pema-500 text-sm font-medium hover:underline mt-1 inline-block">
                        Tambah sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
