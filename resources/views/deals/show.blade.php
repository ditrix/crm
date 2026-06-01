<x-layout>
    <x-slot name="heading">{{ $deal->title }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="mb-4 flex items-center gap-3">
        <a href="{{ route('deals.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">
            <x-icon name="chevron-left" class="w-4 h-4" />{{ __('messages.deals') }}
        </a>
        @can('update', $deal)
        <a href="{{ route('deals.edit', $deal) }}"
           class="ml-auto inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
            <x-icon name="pencil" class="w-4 h-4" />{{ __('messages.edit') }}
        </a>
        @endcan
    </div>

    <div class="max-w-2xl space-y-5">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 space-y-4">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $deal->title }}</h2>
                @if($deal->client)
                <a href="{{ route('clients.show', $deal->client) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                    {{ $deal->client->name }}
                </a>
                @endif
            </div>
            <x-status-badge :slug="$deal->status?->slug" :name="$deal->status?->name" />
        </div>

        @if($deal->amount)
        <div class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ number_format($deal->amount, 0, '.', ' ') }}
        </div>
        @endif

        @if($deal->comment)
        <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
            <p class="text-xs font-medium text-gray-400 dark:text-gray-500 mb-1">{{ __('messages.deal_comment') }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $deal->comment }}</p>
        </div>
        @endif

        <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
            <x-updated-by :user="$deal->updatedBy" :date="$deal->updated_at" />
        </div>
    </div>

    {{-- Files --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5">
        <h3 class="font-medium text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <x-icon name="paper-clip" class="w-4 h-4 text-gray-400" />
            {{ __('messages.files') }}
        </h3>
        <x-file-uploader fileable-type="deal" :fileable-id="$deal->id" :files="$deal->files" />
    </div>
    </div>
</x-layout>
