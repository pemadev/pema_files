@extends('admin.layouts.master')

@section('title', 'Pengaturan')
@section('page_title', 'Pengaturan')

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
    $lat = old('latitude', $settings['latitude'] ?: null);
    $lng = old('longitude', $settings['longitude'] ?: null);
@endphp
<div class="max-w-3xl" x-data="{
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
        
        this.map = L.map('settings-map').setView([defaultLat, defaultLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);
        
        if (this.latitude && this.longitude) {
            this.marker = L.marker([this.latitude, this.longitude]).addTo(this.map);
        }
        
        this.map.on('click', (e) => {
            this.setLocation(e.latlng.lat, e.latlng.lng);
        });
        
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
        
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data.display_name) {
                    document.getElementById('alamat').value = data.display_name;
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
    clearLocation() {
        this.latitude = null;
        this.longitude = null;
        if (this.marker) {
            this.map.removeLayer(this.marker);
            this.marker = null;
        }
    }
}" x-init="initMap()">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        <!-- Informasi Kontak -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-pema-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-info text-pema-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Informasi Kontak</h3>
            </div>
            <div class="p-5 space-y-5">
                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                    <textarea id="alamat"
                              name="alamat"
                              rows="3"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('alamat') border-red-300 @enderror"
                              placeholder="Alamat lengkap perusahaan">{{ old('alamat', $settings['alamat']) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', $settings['email']) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('email') border-red-300 @enderror"
                           placeholder="info@pema.co.id">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon & Fax -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1.5">Telepon</label>
                        <input type="text"
                               id="telepon"
                               name="telepon"
                               value="{{ old('telepon', $settings['telepon']) }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('telepon') border-red-300 @enderror"
                               placeholder="(021) 12345678">
                        @error('telepon')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="fax" class="block text-sm font-medium text-gray-700 mb-1.5">Fax</label>
                        <input type="text"
                               id="fax"
                               name="fax"
                               value="{{ old('fax', $settings['fax']) }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('fax') border-red-300 @enderror"
                               placeholder="(021) 12345679">
                        @error('fax')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Lokasi Perusahaan -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-marker text-green-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Lokasi Perusahaan</h3>
            </div>
            <div class="p-5 space-y-5">
                <!-- Map Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cari Lokasi di Peta</label>
                    <div class="relative">
                        <input type="text"
                               x-model="searchQuery"
                               @input.debounce.300ms="searchSuggestions()"
                               @keydown.enter.prevent=""
                               @keydown.escape="showSuggestions = false"
                               @click.outside="showSuggestions = false"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 outline-none transition-all text-sm"
                               placeholder="Cari alamat (contoh: Banda Aceh)">
                        
                        <div x-show="showSuggestions && suggestions.length > 0" x-cloak
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
                        
                        <div x-show="searching" x-cloak class="absolute right-10 top-1/2 -translate-y-1/2">
                            <svg class="animate-spin h-4 w-4 text-pema-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Ketik alamat untuk rekomendasi, atau klik pada peta untuk menandai lokasi</p>
                </div>

                <!-- Map -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Peta Lokasi</label>
                    <div class="map-container">
                        <div id="settings-map"></div>
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
            </div>
        </div>

        <!-- Karir Link -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-briefcase text-amber-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Link Pendaftaran Karir</h3>
            </div>
            <div class="p-5 space-y-5">
                <div>
                    <label for="karir_link" class="block text-sm font-medium text-gray-700 mb-1.5">Link Google Form</label>
                    <div class="flex gap-2">
                        <input type="url"
                               id="karir_link"
                               name="karir_link"
                               value="{{ old('karir_link', $settings['karir_link']) }}"
                               class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('karir_link') border-red-300 @enderror"
                               placeholder="https://docs.google.com/forms/d/...">
                        @if(!empty($settings['karir_link']) && $settings['karir_link'] !== '#')
                            <a href="{{ $settings['karir_link'] }}" 
                               target="_blank"
                               class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition-colors flex items-center gap-1 text-xs font-medium">
                                <i class="fi fi-rs-external-link text-sm"></i>
                                Cek
                            </a>
                        @endif
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Link Google Form untuk pendaftaran karir di halaman publik</p>
                    @error('karir_link')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sosial Media -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rs-share text-blue-500 text-sm"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 text-sm">Sosial Media</h3>
            </div>
            <div class="p-5 space-y-5">
                <!-- Produk Link -->
                <div>
                    <label for="produk_link" class="block text-sm font-medium text-gray-700 mb-1.5">
                        <i class="fi fi-rs-shopping-cart text-sm text-gray-400 mr-1"></i> Link Produk (Navbar)
                    </label>
                    <div class="flex gap-2">
                        <input type="url"
                               id="produk_link"
                               name="produk_link"
                               value="{{ old('produk_link', $settings['produk_link']) }}"
                               class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('produk_link') border-red-300 @enderror"
                               placeholder="https://example.com">
                        @if(!empty($settings['produk_link']) && $settings['produk_link'] !== '#')
                            <a href="{{ $settings['produk_link'] }}" 
                               target="_blank"
                               class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition-colors flex items-center gap-1 text-xs font-medium">
                                <i class="fi fi-rs-external-link text-sm"></i>
                                Cek
                            </a>
                        @endif
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Link halaman produk di navbar (buka di tab baru)</p>
                    @error('produk_link')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Instagram -->
                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 mb-1.5">
                            <i class="fi fi-brands-instagram text-sm text-gray-400 mr-1"></i> Instagram
                        </label>
                        <div class="flex gap-2">
                            <input type="text"
                                   id="instagram"
                                   name="instagram"
                                   value="{{ old('instagram', $settings['instagram']) }}"
                                   class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('instagram') border-red-300 @enderror"
                                   placeholder="https://instagram.com/pema">
                            @if(old('instagram', $settings['instagram']))
                                <a href="{{ old('instagram', $settings['instagram']) }}" 
                                   target="_blank"
                                   class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition-colors flex items-center gap-1 text-xs font-medium">
                                    <i class="fi fi-rs-external-link text-sm"></i>
                                    Cek
                                </a>
                            @endif
                        </div>
                        @error('instagram')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Facebook -->
                    <div>
                        <label for="facebook" class="block text-sm font-medium text-gray-700 mb-1.5">
                            <i class="fi fi-brands-facebook text-sm text-gray-400 mr-1"></i> Facebook
                        </label>
                        <div class="flex gap-2">
                            <input type="text"
                                   id="facebook"
                                   name="facebook"
                                   value="{{ old('facebook', $settings['facebook']) }}"
                                   class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('facebook') border-red-300 @enderror"
                                   placeholder="https://facebook.com/pema">
                            @if(old('facebook', $settings['facebook']))
                                <a href="{{ old('facebook', $settings['facebook']) }}" 
                                   target="_blank"
                                   class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition-colors flex items-center gap-1 text-xs font-medium">
                                    <i class="fi fi-rs-external-link text-sm"></i>
                                    Cek
                                </a>
                            @endif
                        </div>
                        @error('facebook')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Twitter / X -->
                    <div>
                        <label for="twitter" class="block text-sm font-medium text-gray-700 mb-1.5">
                            <i class="fi fi-brands-twitter text-sm text-gray-400 mr-1"></i> Twitter / X
                        </label>
                        <div class="flex gap-2">
                            <input type="text"
                                   id="twitter"
                                   name="twitter"
                                   value="{{ old('twitter', $settings['twitter']) }}"
                                   class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('twitter') border-red-300 @enderror"
                                   placeholder="https://twitter.com/pema">
                            @if(old('twitter', $settings['twitter']))
                                <a href="{{ old('twitter', $settings['twitter']) }}" 
                                   target="_blank"
                                   class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition-colors flex items-center gap-1 text-xs font-medium">
                                    <i class="fi fi-rs-external-link text-sm"></i>
                                    Cek
                                </a>
                            @endif
                        </div>
                        @error('twitter')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- YouTube -->
                    <div>
                        <label for="youtube" class="block text-sm font-medium text-gray-700 mb-1.5">
                            <i class="fi fi-brands-youtube text-sm text-gray-400 mr-1"></i> YouTube
                        </label>
                        <div class="flex gap-2">
                            <input type="text"
                                   id="youtube"
                                   name="youtube"
                                   value="{{ old('youtube', $settings['youtube']) }}"
                                   class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pema-500/20 focus:border-pema-500 text-sm transition-all @error('youtube') border-red-300 @enderror"
                                   placeholder="https://youtube.com/@pema">
                            @if(old('youtube', $settings['youtube']))
                                <a href="{{ old('youtube', $settings['youtube']) }}" 
                                   target="_blank"
                                   class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition-colors flex items-center gap-1 text-xs font-medium">
                                    <i class="fi fi-rs-external-link text-sm"></i>
                                    Cek
                                </a>
                            @endif
                        </div>
                        @error('youtube')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end mb-6">
            <button type="submit"
                    class="px-6 py-2.5 bg-pema-500 hover:bg-pema-600 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center gap-2">
                <i class="fi fi-rs-save text-sm"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush
@endsection
