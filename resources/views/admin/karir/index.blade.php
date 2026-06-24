@extends('admin.layouts.master')

@section('title', 'Lowongan Karir')
@section('page_title', 'Lowongan Karir')

@section('content')
<div class="space-y-6" x-data="{ deleteUrl: '' }" x-on:confirm-action.window="
    if($event.detail.id==='delete-confirm') { const f=document.createElement('form'); f.method='POST'; f.action=deleteUrl; const t=document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'); f.innerHTML='<input type=\'hidden\' name=\'_token\' value=\''+t+'\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'>'; document.body.appendChild(f); f.submit(); }
">
    <x-admin.confirm-modal
        id="delete-confirm"
        title="Hapus Lowongan"
        message="Apakah Anda yakin ingin menghapus lowongan ini? Data yang sudah dihapus tidak dapat dikembalikan."
        confirmText="Ya, Hapus"
        variant="danger"
    />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-gray-500">Kelola lowongan pekerjaan</p>
        </div>
        <a href="{{ route('admin.karir.create') }}"
           class="inline-flex items-center gap-2 bg-pema-500 text-white px-5 py-2.5 rounded-xl hover:bg-pema-600 transition-all text-sm font-medium shadow-sm">
            <i class="fi fi-rs-plus text-base"></i>
            Tambah Lowongan
        </a>
    </div>

    <div class="mb-5">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari lowongan..." value="{{ request('search') }}"
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
                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                        <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3.5 text-left">Judul</th>
                        <th class="px-5 py-3.5 text-left">Departemen</th>
                        <th class="px-5 py-3.5 text-center">Tipe</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($job->thumbnail)
                                        <img src="{{ asset('storage/' . $job->thumbnail) }}" alt="" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-pema-50 flex items-center justify-center flex-shrink-0">
                                            <i class="fi fi-rs-briefcase text-pema-400 text-sm"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <span class="font-medium text-gray-900 block truncate">{{ $job->title }}</span>
                                        @if($job->google_form_link)
                                            <a href="{{ $job->google_form_link }}" target="_blank" class="text-xs text-pema-500 hover:text-pema-600">
                                                <i class="fi fi-rs-external-link text-xs"></i> Google Form
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-gray-500 text-sm">{{ $job->department ?: '-' }}</td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-50 text-xs font-medium text-gray-600 capitalize">
                                    {{ $job->type }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($job->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-green-50 text-green-600 text-xs font-medium">
                                        <i class="fi fi-rs-check-circle text-xs"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-50 text-gray-400 text-xs font-medium">
                                        <i class="fi fi-rs-eye-slash text-xs"></i>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.karir.edit', $job) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium">
                                        <i class="fi fi-rs-edit"></i>
                                        Edit
                                    </a>
                                    <button type="button"
                                            x-on:click="deleteUrl = '{{ route('admin.karir.destroy', $job) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
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
                                        <i class="fi fi-rs-briefcase text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-sm text-gray-400">Belum ada lowongan.</p>
                                    <a href="{{ route('admin.karir.create') }}"
                                       class="text-pema-500 hover:text-pema-600 text-sm font-medium">
                                        Tambah lowongan sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jobs->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
