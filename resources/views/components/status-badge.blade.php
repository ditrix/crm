@props(['slug' => null, 'name' => null])

@php
$colors = [
    'potential'   => 'bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300',
    'active'      => 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300',
    'in_progress' => 'bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300',
    'completed'   => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
];
$cls = $colors[$slug] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400';
@endphp

@if($name)
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cls }}">
    {{ $name }}
</span>
@else
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-500">—</span>
@endif
