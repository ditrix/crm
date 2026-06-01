<x-layout>
    <x-slot name="heading">{{ __('messages.edit_deal') }}</x-slot>
    <div class="max-w-2xl">
        <div class="mb-4">
            <a href="{{ route('deals.show', $deal) }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">
                <x-icon name="chevron-left" class="w-4 h-4" />{{ $deal->title }}
            </a>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
            @include('deals._form', ['deal' => $deal, 'route' => route('deals.update', $deal), 'method' => 'PUT', 'statuses' => $statuses, 'clients' => $clients])
        </div>
    </div>
</x-layout>
