@extends('admin.layouts.master')

@section('title', 'Pengguna')
@section('page_title', 'Pengguna')

@section('content')
<div x-data="{ deleteUrl: '' }"
     @confirm-action.window="if($event.detail.id === 'delete-confirm') { const f=document.createElement('form'); f.method='POST'; f.action=deleteUrl; const t=document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'); f.innerHTML='<input type=\'hidden\' name=\'_token\' value=\''+t+'\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'>'; document.body.appendChild(f); f.submit(); }">
    <x-admin.confirm-modal
        id="delete-confirm"
        title="Hapus Pengguna"
        message="Apakah Anda yakin ingin menghapus pengguna ini? Semua data terkait juga akan dihapus."
        confirmText="Ya, Hapus"
        variant="danger"
    />
    <div class="flex items-center justify-between mb-5">
        <p class="text-sm text-gray-500">Kelola akun pengguna admin.</p>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm">
            <i class="fi fi-rs-plus text-sm"></i>
            Tambah Pengguna
        </a>
    </div>

    <!-- Search -->
    <div class="mb-5">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}"
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

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">
                            <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('sort_by', 'sort_dir', 'page'), ['sort_by' => 'name', 'sort_dir' => request('sort_by') === 'name' && request('sort_dir') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-pema-500 transition-colors inline-flex items-center gap-1.5">
                                Nama
                                @if(request('sort_by') === 'name')
                                    <i class="fi {{ request('sort_dir') === 'asc' ? 'fi-rs-arrow-small-up' : 'fi-rs-arrow-small-down' }} text-pema-500 text-xs"></i>
                                @else
                                    <i class="fi fi-rs-arrows-h text-gray-300 text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">
                            <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('sort_by', 'sort_dir', 'page'), ['sort_by' => 'email', 'sort_dir' => request('sort_by') === 'email' && request('sort_dir') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-pema-500 transition-colors inline-flex items-center gap-1.5">
                                Email
                                @if(request('sort_by') === 'email')
                                    <i class="fi {{ request('sort_dir') === 'asc' ? 'fi-rs-arrow-small-up' : 'fi-rs-arrow-small-down' }} text-pema-500 text-xs"></i>
                                @else
                                    <i class="fi fi-rs-arrows-h text-gray-300 text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">
                            <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('sort_by', 'sort_dir', 'page'), ['sort_by' => 'created_at', 'sort_dir' => request('sort_by') === 'created_at' && request('sort_dir') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-pema-500 transition-colors inline-flex items-center gap-1.5">
                                Dibuat
                                @if(request('sort_by') === 'created_at')
                                    <i class="fi {{ request('sort_dir') === 'asc' ? 'fi-rs-arrow-small-up' : 'fi-rs-arrow-small-down' }} text-pema-500 text-xs"></i>
                                @else
                                    <i class="fi fi-rs-arrows-h text-gray-300 text-xs"></i>
                                @endif
                            </a>
                        </th>
                        <th class="text-right px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-pema-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-pema-600 font-semibold text-sm">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-5 py-4 text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                     <a href="{{ $user->id === auth()->id() ? route('admin.profile.edit') : route('admin.users.edit', $user) }}"
                                         class="inline-flex items-center gap-1.5 px-3 py-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium">
                                          <i class="fi fi-rs-edit"></i>
                                          Edit
                                      </a>
                                    @if($user->id !== auth()->id())
                                        <button type="button"
                                                x-on:click="deleteUrl = '{{ route('admin.users.destroy', $user) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                            <i class="fi fi-rs-trash"></i>
                                            Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <i class="fi fi-rs-users text-gray-300 text-4xl mb-3 inline-block"></i>
                                <p class="text-gray-500 text-sm">Belum ada pengguna.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
