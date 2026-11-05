{{-- Form ubah status + catatan petugas (dipakai di semua halaman detail) --}}
@php
    $dot = ['success' => 'bg-green-500', 'warning' => 'bg-amber-500', 'error' => 'bg-red-500', 'brand' => 'bg-pema-500', 'gray' => 'bg-gray-400'];
    $ring = ['success' => 'peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700', 'warning' => 'peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700', 'error' => 'peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700', 'brand' => 'peer-checked:border-pema-500 peer-checked:bg-pema-50 peer-checked:text-pema-700', 'gray' => 'peer-checked:border-gray-500 peer-checked:bg-gray-50 peer-checked:text-gray-800'];
    $current = old('status', $item->status);
    $note = old($noteField, $item->{$noteField});
@endphp
<form method="POST" action="{{ route("ppid.{$routeName}.update", $item->id) }}" class="space-y-5"
      x-data="{ status: @js($current), original: @js($item->status), note: @js((string) $note), saving: false }"
      @submit="saving = true">
    @csrf
    @method('PUT')

    <fieldset>
        <legend class="mb-2 block text-sm font-medium text-gray-700">Status</legend>
        <div class="grid grid-cols-2 gap-2">
            @foreach ($statuses as $key => $def)
                <label class="relative cursor-pointer">
                    <input type="radio" name="status" value="{{ $key }}" x-model="status" class="peer sr-only" @checked($current === $key)>
                    <span class="flex items-center gap-2 rounded-xl border-2 border-gray-200 bg-white px-3 py-2.5 text-sm font-medium text-gray-600 transition-all duration-200 hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-sm peer-focus-visible:ring-2 peer-focus-visible:ring-pema-400 peer-focus-visible:ring-offset-2 {{ $ring[$def['color']] ?? $ring['gray'] }}">
                        <span class="h-2.5 w-2.5 flex-shrink-0 rounded-full {{ $dot[$def['color']] ?? 'bg-gray-400' }}" aria-hidden="true"></span>
                        {{ $def['label'] }}
                    </span>
                </label>
            @endforeach
        </div>
    </fieldset>

    <div>
        <div class="mb-2 flex items-center justify-between">
            <label for="{{ $noteField }}" class="text-sm font-medium text-gray-700">{{ $noteLabel }}</label>
            <span class="text-xs tabular-nums text-gray-400" x-text="note.length + ' / 5000'"></span>
        </div>
        <textarea id="{{ $noteField }}" name="{{ $noteField }}" rows="6" maxlength="5000" x-model="note"
                  placeholder="{{ $notePlaceholder }}"
                  class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 shadow-sm transition-all duration-200 placeholder:text-gray-400 hover:border-pema-300 focus:border-pema-400 focus:outline-none focus:ring-4 focus:ring-pema-500/15">{{ $note }}</textarea>
    </div>

    <p x-show="status !== original" x-cloak class="flex items-center gap-2 rounded-xl bg-amber-50 px-3 py-2 text-xs text-amber-800">
        <i class="fi fi-rs-info"></i>
        Status akan diubah. Klik Simpan untuk menerapkan.
    </p>

    <button type="submit" :disabled="saving"
            class="inline-flex h-11 w-full items-center justify-center gap-2 rounded-xl bg-pema-500 px-4 text-sm font-semibold text-white shadow-md shadow-pema-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-pema-600 hover:shadow-lg active:translate-y-0 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pema-400 focus-visible:ring-offset-2 disabled:cursor-wait disabled:opacity-70">
        <i class="fi fi-rs-disk" x-show="!saving"></i>
        <svg x-show="saving" x-cloak class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" opacity=".25"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
        <span x-text="saving ? 'Menyimpan…' : 'Simpan status'">Simpan status</span>
    </button>

    @if ($item->tanggal_selesai)
        <p class="flex items-center justify-center gap-1.5 text-xs text-gray-500">
            <i class="fi fi-rs-check-circle text-green-500"></i>
            Diselesaikan {{ $item->tanggal_selesai->translatedFormat('d F Y') }}
        </p>
    @endif
</form>