<div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
    <dt class="text-sm text-gray-500">{{ $label }}</dt>
    <dd class="text-sm text-gray-800 sm:col-span-2 {{ $multiline ?? false ? 'whitespace-pre-line' : '' }}">{{ filled($value) ? $value : '—' }}</dd>
</div>