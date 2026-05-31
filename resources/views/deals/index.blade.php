<x-layout>
    <x-slot name="heading">{{ __('messages.deals') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center gap-3 mb-5">
        <form method="GET" action="{{ route('deals.index') }}" class="flex-1 min-w-0 flex items-center gap-2">
            @foreach(request()->except(['search','page']) as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
            <div class="relative flex-1 max-w-xs">
                <x-icon name="magnifying-glass" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="{{ __('messages.search') }}…"
                       class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <select name="status" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">{{ __('messages.all_statuses') }}</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" @selected(request('status') == $status->id)>{{ $status->name }}</option>
                @endforeach
            </select>
        </form>

        <x-archive-toggle :showArchived="$showArchived" route="deals.index" />

        @can('create', \App\Models\Deal::class)
        <a href="{{ route('deals.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
            <x-icon name="plus" class="w-4 h-4" />
            {{ __('messages.add_deal') }}
        </a>
        @endcan
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-700 text-left">
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.deal_title') }}</th>
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ __('messages.deal_client') }}</th>
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell">{{ __('messages.deal_status') }}</th>
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell">{{ __('messages.deal_amount') }}</th>
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden xl:table-cell">{{ __('messages.updated_by') }}</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                @forelse($deals as $deal)
                <tr class="{{ $deal->trashed() ? 'opacity-50' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $deal->title }}</td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ $deal->client?->name ?? '—' }}</td>
                    <td class="px-4 py-3 hidden lg:table-cell">
                        <x-status-badge :slug="$deal->status?->slug" :name="$deal->status?->name" />
                    </td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 hidden lg:table-cell">
                        {{ $deal->amount ? number_format($deal->amount, 0, '.', ' ') : '—' }}
                    </td>
                    <td class="px-4 py-3 hidden xl:table-cell">
                        <x-updated-by :user="$deal->updatedBy" :date="$deal->updated_at" />
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1">
                            @if($deal->trashed())
                                @can('restore', $deal)
                                <form method="POST" action="{{ route('deals.restore', $deal->id) }}">
                                    @csrf
                                    <button type="submit" title="{{ __('messages.restore') }}"
                                            class="p-1.5 rounded-lg text-green-500 hover:bg-green-50 dark:hover:bg-green-900/20 transition">
                                        <x-icon name="arrow-uturn-left" class="w-4 h-4" />
                                    </button>
                                </form>
                                @endcan
                            @else
                                <a href="{{ route('deals.show', $deal) }}"
                                   class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <x-icon name="eye" class="w-4 h-4" />
                                </a>
                                @can('update', $deal)
                                <a href="{{ route('deals.edit', $deal) }}"
                                   class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </a>
                                @endcan
                                @can('delete', $deal)
                                <form method="POST" action="{{ route('deals.destroy', $deal) }}"
                                      x-data
                                      @submit.prevent="if(confirm('{{ __('messages.confirm_delete') }}')) $el.submit()">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 rounded-lg text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-500 transition">
                                        <x-icon name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                                @endcan
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-400 dark:text-gray-500">{{ __('messages.no_data') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($deals->hasPages())
    <div class="mt-4">{{ $deals->links() }}</div>
    @endif
</x-layout>
