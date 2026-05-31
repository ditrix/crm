<x-layout>
    <x-slot name="heading">{{ __('messages.add_deal') }}</x-slot>
    <div class="max-w-2xl">
        <div class="mb-4">
            <a href="{{ route('deals.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">
                <x-icon name="chevron-left" class="w-4 h-4" />{{ __('messages.deals') }}
            </a>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
            @include('deals._form', ['route' => route('deals.store'), 'statuses' => $statuses, 'clients' => $clients, 'selected' => $selected])
        </div>
    </div>
</x-layout>
