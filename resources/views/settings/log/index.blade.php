<x-layout>
    <x-slot name="heading">{{ __('messages.system_log') }}</x-slot>

    <div class="mb-3 flex items-center justify-between">
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('messages.log_lines_total') }}: <span class="font-medium text-gray-700 dark:text-gray-200">{{ number_format($total) }}</span>
        </p>
        <div class="flex items-center gap-2 text-sm">
            @if($page > 1)
                <a href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}"
                   class="px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    &larr; {{ __('messages.prev') }}
                </a>
            @endif
            <span class="text-gray-400">{{ $page }} / {{ $lastPage }}</span>
            @if($page < $lastPage)
                <a href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}"
                   class="px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    {{ __('messages.next') }} &rarr;
                </a>
            @endif
        </div>
    </div>

    <div class="bg-gray-900 dark:bg-gray-950 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <pre class="text-xs text-green-400 font-mono p-5 whitespace-pre-wrap leading-relaxed max-h-[75vh] overflow-y-auto">@if(count($lines))@foreach($lines as $line)@php
    $cls = match(true) {
        str_contains($line, '.ERROR')    => 'text-red-400',
        str_contains($line, '.WARNING')  => 'text-yellow-400',
        str_contains($line, '.INFO')     => 'text-blue-400',
        str_contains($line, '.DEBUG')    => 'text-gray-500',
        default                          => 'text-green-400',
    };
@endphp<span class="{{ $cls }}">{{ $line }}</span>
@endforeach@else<span class="text-gray-500">{{ __('messages.log_empty') }}</span>@endif</pre>
        </div>
    </div>
</x-layout>
