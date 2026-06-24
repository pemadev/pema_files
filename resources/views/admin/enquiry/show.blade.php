@extends('admin.layouts.master')

@section('title', 'Detail Pesan')
@section('page_title', 'Detail Pesan')

@section('content')
<div class="max-w-4xl" x-data="{ deleteUrl: '' }" x-on:confirm-action.window="
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
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.enquiry.index') }}" class="inline-flex items-center gap-2 text-pema-500 hover:text-pema-600 font-medium">
            <i class="fi fi-rs-arrow-left text-lg"></i>
            Kembali
        </a>
        <div class="flex items-center gap-2">
            @if(!$enquiry->is_read)
            <form action="{{ route('admin.enquiry.read', $enquiry) }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <button type="submit" class="px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-sm font-medium transition-all">
                    <i class="fi fi-rs-check text-sm"></i> Tandai Sudah Dibaca
                </button>
            </form>
            @else
            <form action="{{ route('admin.enquiry.unread', $enquiry) }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <button type="submit" class="px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-medium transition-all">
                    <i class="fi fi-rs-circle text-sm"></i> Tandai Belum Dibaca
                </button>
            </form>
            @endif
                            <button type="button"
                                    x-on:click="deleteUrl = '{{ route('admin.enquiry.destroy', $enquiry) }}'; $dispatch('open-confirm-modal', { id: 'delete-confirm' })"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                <i class="fi fi-rs-trash"></i> Hapus
                            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <!-- Info Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="grid sm:grid-cols-2 gap-6">
                <!-- Pengirim -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Dari</p>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $enquiry->name }}</h3>
                    <a href="mailto:{{ $enquiry->email }}" class="text-sm text-pema-500 hover:text-pema-600 mt-1 inline-block">
                        {{ $enquiry->email }}
                    </a>
                    @if($enquiry->phone)
                    <p class="text-sm text-gray-600 mt-2">
                        <a href="tel:{{ $enquiry->phone }}" class="text-pema-500 hover:text-pema-600">
                            {{ $enquiry->phone }}
                        </a>
                    </p>
                    @endif
                </div>

                <!-- Metadata -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Info Pesan</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Dikirim:</span>
                            <span class="font-medium text-gray-900">{{ $enquiry->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                @if($enquiry->is_read) 
                                    bg-green-100 text-green-700
                                @else
                                    bg-yellow-100 text-yellow-700
                                @endif">
                                @if($enquiry->is_read)
                                    <i class="fi fi-rs-check text-xs"></i>
                                    Sudah Dibaca
                                @else
                                    <i class="fi fi-rs-circle text-xs"></i>
                                    Belum Dibaca
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjek -->
        <div class="px-6 py-4 border-b border-gray-100">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Subjek</p>
            <h2 class="text-xl font-bold text-gray-900">{{ $enquiry->subject }}</h2>
        </div>

        <!-- Pesan -->
        <div class="px-6 py-6">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Isi Pesan</p>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $enquiry->message }}</p>
            </div>
        </div>

        <!-- Actions Footer -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
            <p class="text-xs text-gray-500">ID: <span class="font-mono">{{ $enquiry->id }}</span></p>
            <div class="flex items-center gap-3">
                <a href="mailto:{{ $enquiry->email }}" class="px-4 py-2 bg-pema-500 text-white rounded-lg hover:bg-pema-600 font-medium text-sm transition-all">
                    <i class="fi fi-rs-envelope text-sm"></i> Balas Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
