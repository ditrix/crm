@props(['type' => 'success'])

@php
$classes = match($type) {
    'success' => 'bg-green-50 dark:bg-green-900/30 border-green-200 dark:border-green-800 text-green-800 dark:text-green-300',
    'error'   => 'bg-red-50 dark:bg-red-900/30 border-red-200 dark:border-red-800 text-red-800 dark:text-red-300',
    default   => 'bg-blue-50 dark:bg-blue-900/30 border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-300',
};
@endphp

<div class="px-4 py-3 rounded-2xl border text-sm {{ $classes }}">
    {{ $slot }}
</div>
