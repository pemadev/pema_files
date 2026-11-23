{{--
    Avatar pengguna admin: foto profil bila ada, selain itu huruf depan nama.
    <x-admin.avatar :user="$user" size="36" :online="true" />
    :online = true (titik hijau), false (titik abu-abu), null (tanpa titik)
--}}
@props(['user', 'size' => 36, 'online' => null])

@php
    $size = (int) $size;
    $dot = max(9, (int) round($size * 0.3));
    $url = $user?->avatar_url;
@endphp

<span {{ $attributes->merge(['class' => 'relative inline-flex flex-shrink-0']) }} style="width:{{ $size }}px;height:{{ $size }}px">
    {{-- Huruf depan selalu ada di bawah; foto menutupinya. Bila foto gagal dimuat, foto dibuang sehingga huruf terlihat. --}}
    <span class="bg-pema-100 text-pema-600 font-semibold"
          style="width:100%;height:100%;border-radius:9999px;display:flex;align-items:center;justify-content:center;font-size:{{ max(11, (int) round($size * 0.4)) }}px">
        {{ $user?->initial ?? '?' }}
    </span>
    @if($url)
        <img src="{{ $url }}" alt="" onerror="this.remove()"
             style="position:absolute;inset:0;width:100%;height:100%;border-radius:9999px;object-fit:cover;box-shadow:0 0 0 1px rgba(15,23,42,.06)">
    @endif

    @if(! is_null($online))
        <span class="{{ $online ? 'avatar-dot-online' : '' }}" title="{{ $online ? 'Online' : 'Offline' }}"
              style="position:absolute;right:-1px;bottom:-1px;width:{{ $dot }}px;height:{{ $dot }}px;border-radius:9999px;border:2px solid #fff;background:{{ $online ? '#22c55e' : '#cbd5e1' }}"></span>
    @endif
</span>

