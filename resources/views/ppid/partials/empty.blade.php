<div class="px-6 py-16 text-center">
    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-pema-50">
        <i class="fi fi-rs-inbox text-2xl text-pema-500"></i>
    </div>
    <p class="font-medium text-gray-800">{{ $heading }}</p>
    <p class="mt-1 text-sm text-gray-500">
        @if (array_filter($filters))
            Tidak ada data yang cocok dengan filter ini.
            <a class="font-medium text-pema-500 hover:text-pema-600" href="{{ route("ppid.{$routeName}.index") }}">Hapus filter</a>
        @else
            {{ $hint }}
        @endif
    </p>
</div>