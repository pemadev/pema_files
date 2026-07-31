@extends('admin.layouts.master')

@section('title', isset($agendum) ? 'Edit Agenda' : 'Tambah Agenda')
@section('page_title', isset($agendum) ? 'Edit Agenda' : 'Tambah Agenda')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .map-container {
        height: 300px;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }
    .leaflet-container {
        height: 100%;
        width: 100%;
    }
</style>
@endpush

@section('content')
@php
    $lat = old('latitude', isset($agendum) && $agendum->latitude ? $agendum->latitude : null);
    $lng = old('longitude', isset($agendum) && $agendum->longitude ? $agendum->longitude : null);
@endphp
<div class="max-w-2xl" x-data="{
    latitude: {{ $lat ? $lat : 'null' }},
    longitude: {{ $lng ? $lng : 'null' }},
    map: null,
    marker: null,
    searchQuery: '',
    suggestions: [],
    showSuggestions: false,
    searching: false,
    initMap() {
        const defaultLat = this.latitude || 5.5535;
        const defaultLng = this.longitude || 95.3205;
        
        this.map = L.map('map').setView([defaultLat, defaultLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);
        
        if (this.latitude && this.longitude) {
            this.marker = L.marker([this.latitude, this.longitude]).addTo(this.map);
        }
        
        this.map.on('click', (e) => {
            this.setLocation(e.latlng.lat, e.latlng.lng);
        });
        
        // Fix map display issue
        setTimeout(() => {
            this.map.invalidateSize();
        }, 100);
    },
    setLocation(lat, lng) {
        this.latitude = lat;
        this.longitude = lng;
        
        if (this.marker) {
            this.marker.setLatLng([lat, lng]);
        } else {
            this.marker = L.marker([lat, lng]).addTo(this.map);
        }
        
        // Reverse geocode to get address
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data.display_name) {
                    document.getElementById('location').value = data.display_name;
                }
            });
    },
    searchSuggestions() {
        if (!this.searchQuery || this.searchQuery.length < 3) {
            this.suggestions = [];
            this.showSuggestions = false;
            return;
        }
        
        this.searching = true;
        
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&limit=5&addressdetails=1`)
            .then(res => res.json())
            .then(data => {
                this.suggestions = data;
                this.showSuggestions = data.length > 0;
                this.searching = false;
            })
            .catch(() => {
                this.searching = false;
            });
    },
    selectSuggestion(item) {
        this.setLocation(parseFloat(item.lat), parseFloat(item.lon));
        this.searchQuery = item.display_name;
        this.showSuggestions = false;
        this.suggestions = [];
        this.map.setView([item.lat, item.lon], 15);
    },
    searchLocation() {
        if (!this.searchQuery) return;
        
        this.searching = true;
        
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    const result = data[0];
                    this.setLocation(parseFloat(result.lat), parseFloat(result.lon));
                    this.map.setView([result.lat, result.lon], 15);
                }
                this.searching = false;
            })
            .catch(() => {
                this.searching = false;
            });
    },
    clearLocation() {
        this.latitude = null;
        this.longitude = null;
        if (this.marker) {
            this.map.removeLayer(this.marker);
            this.marker = null;
        }
    }
}" x-init="initMap()">
    <form action="{{ isset($agendum) ? route('admin.agenda.update', $agendum) : route('admin.agenda.store') }}"
          method="POST"
          class="space-y-6">
        @csrf
        @if(isset($agendum))
            @method('PUT')
        @endif

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="font-heading font-semibold text-gray-900 text-sm">
                    {{ isset($agendum) ? 'Edit data agenda' : 'Informasi Agenda' }}
                </h3>
            </div>
            <div class="px-6 py-5 space-y-5">
                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title', isset($agendum) ? $agendum->title : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm @error('title') border-red-300 bg-red-50 @enderror"
                           placeholder="Masukkan judul agenda">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Date --}}
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="date"
                           name="date"
                           value="{{ old('date', isset($agendum) ? $agendum->date->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm @error('date') border-red-300 bg-red-50 @enderror">
                    @error('date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="location"
                           name="location"
                           value="{{ old('location', isset($agendum) ? $agendum->location : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm @error('location') border-red-300 bg-red-50 @enderror"
                           placeholder="Masukkan lokasi atau klik pada peta">
                    @error('location')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Map Search --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Cari Lokasi di Peta
                    </label>
                    <div class="relative">
                        <input type="text"
                               x-model="searchQuery"
                               @input.debounce.300ms="searchSuggestions()"
                               @keydown.enter.prevent="searchLocation()"
                               @keydown.escape="showSuggestions = false"
                               @click.outside="showSuggestions = false"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm"
                               placeholder="Cari alamat (contoh: Banda Aceh)">
                        
                        {{-- Suggestions Dropdown --}}
                        <div x-show="showSuggestions && suggestions.length > 0" 
                             x-cloak
                             class="absolute z-50 w-full mt-1 bg-white rounded-xl border border-gray-200 shadow-lg max-h-60 overflow-auto">
                            <template x-for="(item, index) in suggestions" :key="index">
                                <button type="button"
                                        @click="selectSuggestion(item)"
                                        class="w-full px-4 py-3 text-left hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                                    <div class="flex items-start gap-3">
                                        <i class="fi fi-rs-marker text-pema-500 text-sm mt-0.5"></i>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-700 truncate" x-text="item.display_name"></p>
                                        </div>
                                    </div>
                                </button>
                            </template>
                        </div>
                        
                        {{-- Loading indicator --}}
                        <div x-show="searching" x-cloak class="absolute right-10 top-1/2 -translate-y-1/2">
                            <svg class="animate-spin h-4 w-4 text-pema-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Ketik alamat untuk mendapatkan rekomendasi, atau klik pada peta</p>
                </div>

                {{-- Map --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Peta Lokasi
                    </label>
                    <div class="map-container">
                        <div id="map"></div>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <div class="text-xs text-gray-400" x-show="latitude && longitude">
                            <span class="text-green-600"><i class="fi fi-rs-check-circle"></i> Lokasi ditandai</span>
                            <span class="ml-2" x-text="latitude?.toFixed(6) + ', ' + longitude?.toFixed(6)"></span>
                        </div>
                        <button type="button"
                                x-show="latitude && longitude"
                                @click="clearLocation()"
                                class="text-xs text-red-500 hover:text-red-600">
                            <i class="fi fi-rs-trash"></i> Hapus tanda
                        </button>
                    </div>
                    <input type="hidden" name="latitude" :value="latitude">
                    <input type="hidden" name="longitude" :value="longitude">
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Deskripsi
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm resize-none @error('description') border-red-300 bg-red-50 @enderror"
                              placeholder="Masukkan deskripsi agenda (opsional)">{{ old('description', isset($agendum) ? $agendum->description : '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Is Published --}}
                <div>
                    <label class="flex items-center gap-3">
                        <input type="checkbox"
                               name="is_published"
                               value="1"
                               {{ old('is_published', isset($agendum) ? $agendum->is_published : true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 text-pema-500 focus:ring-pema-500">
                        <span class="text-sm font-medium text-gray-700">Publikasikan agenda</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-400 ml-7">Jika tidak dicentang, agenda hanya tersimpan sebagai draft.</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 px-6 pt-4 pb-5 border-t border-gray-100">
                <a href="{{ route('admin.agenda.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 inline-flex items-center gap-2">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                    {{ isset($agendum) ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush
@endsection
