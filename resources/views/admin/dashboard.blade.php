@extends('admin.layouts.master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <a href="{{ route('berita.index') }}" target="_blank" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fi fi-rs-newspaper text-blue-500 text-lg"></i>
                </div>
                <span class="text-2xl font-heading font-bold text-gray-900">{{ $stats['total_berita'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Berita</p>
                <i class="fi fi-rs-external-link text-gray-300 text-xs group-hover:text-pema-500 transition-colors"></i>
            </div>
        </a>

        <a href="{{ route('pengumuman.index') }}" target="_blank" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fi fi-rs-megaphone text-amber-500 text-lg"></i>
                </div>
                <span class="text-2xl font-heading font-bold text-gray-900">{{ $stats['total_pengumuman'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Pengumuman</p>
                <i class="fi fi-rs-external-link text-gray-300 text-xs group-hover:text-pema-500 transition-colors"></i>
            </div>
        </a>

        <a href="{{ route('bisnis') }}" target="_blank" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fi fi-rs-briefcase text-green-500 text-lg"></i>
                </div>
                <span class="text-2xl font-heading font-bold text-gray-900">{{ $stats['total_bisnis'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Bidang Bisnis</p>
                <i class="fi fi-rs-external-link text-gray-300 text-xs group-hover:text-pema-500 transition-colors"></i>
            </div>
        </a>

        <a href="{{ route('galeri') }}" target="_blank" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fi fi-rs-images text-purple-500 text-lg"></i>
                </div>
                <span class="text-2xl font-heading font-bold text-gray-900">{{ $stats['total_galeri'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Galeri Foto</p>
                <i class="fi fi-rs-external-link text-gray-300 text-xs group-hover:text-pema-500 transition-colors"></i>
            </div>
        </a>

        <a href="{{ route('kontak') }}" target="_blank" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fi fi-rs-envelope text-red-500 text-lg"></i>
                </div>
                <span class="text-2xl font-heading font-bold text-gray-900">{{ $stats['total_pesan'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">Pesan Masuk</p>
                <i class="fi fi-rs-external-link text-gray-300 text-xs group-hover:text-pema-500 transition-colors"></i>
            </div>
        </a>
    </div>

    <!-- Quick Links -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Berita Terbaru -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Berita Terbaru</h3>
                <a href="{{ route('admin.berita.index') }}" class="text-pema-500 hover:text-pema-600 text-xs font-medium">Lihat Semua</a>
            </div>
            <div class="p-5">
                @if($stats['berita_terbaru']->count() > 0)
                    <div class="space-y-3">
                        @foreach($stats['berita_terbaru'] as $berita)
                            <div class="flex items-start gap-3 pb-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                                 <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 mt-0.5 bg-gray-50">
                                     @if($berita->image)
                                         <img src="{{ asset('storage/' . $berita->image) }}" alt="" class="w-full h-full object-cover">
                                     @else
                                         <div class="w-full h-full flex items-center justify-center bg-pema-50">
                                             <i class="fi fi-rs-newspaper text-pema-400 text-sm"></i>
                                         </div>
                                     @endif
                                 </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $berita->title }}</p>
                                    <p class="text-xs text-gray-400">{{ $berita->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 text-center py-4">Belum ada berita.</p>
                @endif
            </div>
        </div>

        <!-- Pesan Terbaru -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h3 class="font-heading font-semibold text-gray-900 text-sm">Pesan Masuk</h3>
                    @if($stats['pesan_baru'] > 0)
                    <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-medium text-white bg-red-500 rounded-full">
                        {{ $stats['pesan_baru'] }}
                    </span>
                    @endif
                </div>
                <a href="{{ route('admin.enquiry.index') }}" class="text-pema-500 hover:text-pema-600 text-xs">Lihat Semua</a>
            </div>
            <div class="p-5">
                @if($stats['pesan_terbaru']->count() > 0)
                    <div class="space-y-3">
                        @foreach($stats['pesan_terbaru'] as $pesan)
                            <a href="{{ route('admin.enquiry.show', $pesan) }}" class="flex items-start gap-3 pb-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }} hover:bg-gray-50 -mx-1 px-1 py-1 rounded transition-colors group">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 {{ $pesan->is_read ? 'bg-gray-100' : 'bg-blue-100' }}">
                                    <i class="fi fi-rs-envelope {{ $pesan->is_read ? 'text-gray-500' : 'text-blue-500' }} text-xs"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-medium text-gray-900 truncate group-hover:text-pema-500 transition-colors">{{ $pesan->name }}</p>
                                        @if(!$pesan->is_read)
                                        <span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-1.5"></span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">{{ $pesan->subject }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $pesan->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 text-center py-4">Belum ada pesan masuk.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                <i class="fi fi-rs-clock text-pema-500 text-sm"></i>
            </div>
            <h3 class="font-heading font-semibold text-gray-900 text-sm">Aktivitas Terbaru</h3>
        </div>
        <div class="p-5">
            @if($activities->count() > 0)
                <div class="space-y-4">
                    @foreach($activities as $activity)
                        <div class="flex items-start gap-3 text-sm">
                            <div class="w-7 h-7 rounded-full bg-pema-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-pema-600 font-semibold text-xs">{{ substr($activity->user->name ?? '?', 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-gray-700">
                                    <span class="font-medium text-gray-900">{{ $activity->user->name ?? 'System' }}</span>
                                    @if($activity->action === 'created')
                                        <span class="text-green-600">menambahkan</span>
                                    @elseif($activity->action === 'updated')
                                        <span class="text-amber-600">mengubah</span>
                                    @elseif($activity->action === 'deleted')
                                        <span class="text-red-600">menghapus</span>
                                    @endif
                                    {{ $activity->description }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-4">Belum ada aktivitas.</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-heading font-semibold text-gray-900 text-sm">Aksi Cepat</h3>
        </div>
        <div class="p-5 grid grid-cols-2 gap-3">
            <a href="{{ route('admin.berita.create') }}" class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors group">
                <i class="fi fi-rs-plus text-blue-500 text-lg"></i>
                <span class="text-sm font-medium text-blue-700">Tambah Berita</span>
            </a>
            <a href="{{ route('admin.bisnis.create') }}" class="flex items-center gap-3 p-3 bg-green-50 rounded-xl hover:bg-green-100 transition-colors group">
                <i class="fi fi-rs-plus text-green-500 text-lg"></i>
                <span class="text-sm font-medium text-green-700">Tambah Bisnis</span>
            </a>
            <a href="{{ route('admin.galeri.create') }}" class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors group">
                <i class="fi fi-rs-plus text-purple-500 text-lg"></i>
                <span class="text-sm font-medium text-purple-700">Tambah Galeri</span>
            </a>
            <a href="{{ route('admin.agenda.create') }}" class="flex items-center gap-3 p-3 bg-amber-50 rounded-xl hover:bg-amber-100 transition-colors group">
                <i class="fi fi-rs-plus text-amber-500 text-lg"></i>
                <span class="text-sm font-medium text-amber-700">Tambah Agenda</span>
            </a>
        </div>
    </div>
</div>
@endsection
