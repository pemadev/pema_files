@props([
    'id' => 'confirm-modal',
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin?',
    'confirmText' => 'Ya, Hapus',
    'cancelText' => 'Batal',
    'variant' => 'danger', // danger, warning, info
])

@php
    $variantClasses = match($variant) {
        'danger' => [
            'icon' => 'fi fi-rs-trash text-red-500',
            'confirmBg' => 'bg-red-500 hover:bg-red-600',
            'iconBg' => 'bg-red-100',
        ],
        'warning' => [
            'icon' => 'fi fi-rs-exclamation-triangle text-amber-500',
            'confirmBg' => 'bg-amber-500 hover:bg-amber-600',
            'iconBg' => 'bg-amber-100',
        ],
        'info' => [
            'icon' => 'fi fi-rs-info text-blue-500',
            'confirmBg' => 'bg-blue-500 hover:bg-blue-600',
            'iconBg' => 'bg-blue-100',
        ],
    };
@endphp

<div
    x-data="{ open: false }"
    x-on:open-confirm-modal.window="
        if ($event.detail.id === '{{ $id }}') {
            open = true;
        }
    "
    x-on:close-confirm-modal.window="
        if ($event.detail.id === '{{ $id }}') {
            open = false;
        }
    "
    x-on:keydown.escape.window="open = false"
    x-cloak
>
    <!-- Backdrop -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
        x-on:click="open = false"
    ></div>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-on:click.self="open = false"
    >
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden" x-on:click.stop>
            <!-- Content -->
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <!-- Icon -->
                    <div class="{{ $variantClasses['iconBg'] }} rounded-xl p-3 flex-shrink-0">
                        <i class="{{ $variantClasses['icon'] }} text-xl"></i>
                    </div>
                    <!-- Text -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $message }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                <button
                    type="button"
                    x-on:click="open = false"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200"
                >
                    {{ $cancelText }}
                </button>
                <button
                    type="button"
                    x-on:click="
                        $dispatch('confirm-action', { id: '{{ $id }}' });
                        open = false;
                    "
                    class="px-4 py-2.5 text-sm font-medium text-white {{ $variantClasses['confirmBg'] }} rounded-xl transition-colors duration-200"
                >
                    {{ $confirmText }}
                </button>
            </div>
        </div>
    </div>
</div>
