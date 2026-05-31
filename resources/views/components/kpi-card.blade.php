@props(['value', 'label', 'color' => 'indigo', 'href' => '#'])

@php
$bg = [
    'indigo' => 'bg-indigo-50 dark:bg-indigo-900/20',
    'blue'   => 'bg-blue-50 dark:bg-blue-900/20',
    'green'  => 'bg-green-50 dark:bg-green-900/20',
    'amber'  => 'bg-amber-50 dark:bg-amber-900/20',
    'purple' => 'bg-purple-50 dark:bg-purple-900/20',
    'rose'   => 'bg-rose-50 dark:bg-rose-900/20',
    'gray'   => 'bg-gray-50 dark:bg-gray-700/40',
][$color] ?? 'bg-gray-50 dark:bg-gray-700/40';

$text = [
    'indigo' => 'text-indigo-600 dark:text-indigo-400',
    'blue'   => 'text-blue-600 dark:text-blue-400',
    'green'  => 'text-green-600 dark:text-green-400',
    'amber'  => 'text-amber-600 dark:text-amber-400',
    'purple' => 'text-purple-600 dark:text-purple-400',
    'rose'   => 'text-rose-600 dark:text-rose-400',
    'gray'   => 'text-gray-500 dark:text-gray-400',
][$color] ?? 'text-gray-500';
@endphp

<a href="{{ $href }}"
   class="block {{ $bg }} rounded-2xl p-5 hover:scale-[1.02] transition-transform cursor-pointer">
    <p class="text-3xl font-bold {{ $text }}">{{ $value }}</p>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
</a>
