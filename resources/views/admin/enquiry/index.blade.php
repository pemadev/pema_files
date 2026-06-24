@extends('admin.layouts.master')

@section('title', 'Pesan Kontak')
@section('page_title', 'Pesan Kontak')

@section('content')
<div class="space-y-6" x-data="{ deleteUrl: '' }" x-on:confirm-action.window="
    if($event.detail.id==='delete-confirm') { const f=document.createElement('form'); f.method='POST'; f.action=deleteUrl; const t=document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'); f.innerHTML='<input type=\'hidden\' name=\'_token\' value=\''+t+'\'><input type=\'hidden\' name=\'_method\' value=\'DELETE\'>'; document.body.appendChild(f); f.submit(); }
">
    <x-admin.confirm-modal
        id="delete-confirm"
        title="Hapus Pesan"
        message="Apakah Anda yakin ingin menghapus pesan ini? Data yang sudah dihapus tidak dapat dikembalikan."
        confirmText="Ya, Hapus"
        variant="danger"
    />
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Daftar Pesan</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $enquiries->total() }} pesan diterima</p>
        </div>
        @if($unread_count > 0)
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">
            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
            {{ $unread_count }} belum dibaca
        </div>
        @endif
    </div>

    {{-- Search & Filter --}}
    <div class="mb-5">
        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari nama, email, atau subjek..." value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all">
            </div>
            <select name="filter"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all bg-white">
                <option value="">Semua</option>
                <option value="unread" {{ request('filter') === 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                <option value="read" {{ request('filter') === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
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

    <!-- Alerts -->
    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
        <i class="fi fi-rs-exclamation text-red-500 text-lg flex-shrink-0 mt-0.5"></i>
        <div>
            <h4 class="font-semibold text-red-900 text-sm">Terjadi Kesalahan</h4>
            <ul class="text-sm text-red-700 mt-1 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Messages Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($enquiries->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Subjek</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Tanggal</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-center font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($enquiries as $enquiry)
                    <tr class="hover:bg-gray-50 transition-colors {{ !$enquiry->is_read ? 'bg-blue-50/50' : '' }}">
                        <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if(!$enquiry->is_read)
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                                @endif
                                <span class="font-medium text-gray-900">{{ $enquiry->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="mailto:{{ $enquiry->email }}" class="text-pema-500 hover:text-pema-600 text-xs truncate max-w-xs">
                                {{ $enquiry->email }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-600 line-clamp-1">{{ $enquiry->subject }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">
                            {{ $enquiry->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($enquiry->is_read)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                <i class="fi fi-rs-check text-xs"></i>
                                Dibaca
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                <i class="fi fi-rs-circle text-xs"></i>
                                Baru
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.enquiry.show', $enquiry) }}" 
                                   class="p-2 text-gray-600 hover:text-pema-500 hover:bg-pema-50 rounded-lg transition-all"
                                   title="Baca">
                                    <i class="fi fi-rs-eye text-lg"></i>
                                </a>
                                <button type="button"
                                        x-on:click="deleteUrl = '{{ route('admin.enquiry.destroy', $enquiry) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                    <i class="fi fi-rs-trash"></i>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($enquiries->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $enquiries->links(data: ['view' => 'pagination::tailwind']) }}
        </div>
        @endif
        @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fi fi-rs-envelope text-gray-300 text-3xl"></i>
            </div>
            <p class="text-gray-500 font-medium">Belum ada pesan masuk</p>
            <p class="text-sm text-gray-400 mt-1">Pesan dari publik akan muncul di sini</p>
        </div>
        @endif
    </div>
</div>
@endsection
