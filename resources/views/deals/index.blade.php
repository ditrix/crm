<x-layout>
    <x-slot name="heading">{{ __('messages.deals') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div x-data="crmTable()">
        {{-- Toolbar --}}
        <div class="flex flex-wrap items-center gap-3 mb-5">
            {{-- Left: archive toggle + server-side filters --}}
            <div class="flex items-center gap-3 flex-wrap">
                {{-- Styled archive checkbox --}}
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <div class="relative">
                        <input type="checkbox" class="sr-only peer"
                               {{ $showArchived ? 'checked' : '' }}
                               @change="toggleArchive()">
                        <div class="w-10 h-6 rounded-full transition-colors
                                    bg-gray-200 dark:bg-gray-600
                                    peer-checked:bg-amber-500 dark:peer-checked:bg-amber-500">
                        </div>
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform
                                    peer-checked:translate-x-4">
                        </div>
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.show_archived') }}</span>
                </label>

                {{-- Status filter --}}
                <select @change="updateFilter('status', $event.target.value)"
                        class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">{{ __('messages.all_statuses') }}</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Client filter --}}
                <select @change="updateFilter('client', $event.target.value)"
                        class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">{{ __('messages.all_managers') }}</option>
                    @foreach($clients as $cl)
                        <option value="{{ $cl->id }}" {{ request('client') == $cl->id ? 'selected' : '' }}>
                            {{ $cl->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Right: search + add --}}
            <div class="flex items-center gap-3 ml-auto">
                {{-- Search --}}
                <div class="relative">
                    <x-icon name="magnifying-glass" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                    <input type="text" x-model="search"
                           placeholder="{{ __('messages.search') }}…"
                           class="pl-9 pr-8 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-52">
                    <button x-show="search" @click="search = ''"
                            class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <x-icon name="x-mark" class="w-4 h-4" />
                    </button>
                </div>

                @can('create', \App\Models\Deal::class)
                <a href="{{ route('deals.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
                    <x-icon name="plus" class="w-4 h-4" />
                    {{ __('messages.add_deal') }}
                </a>
                @endcan
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700 text-left">
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 cursor-pointer select-none w-16"
                            @click="sort('id')">
                            <div class="flex items-center gap-1">
                                ID
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'id' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'id' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 cursor-pointer select-none"
                            @click="sort('title')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.deal_title') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'title' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'title' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden md:table-cell cursor-pointer select-none"
                            @click="sort('client')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.deal_client') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'client' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'client' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell cursor-pointer select-none"
                            @click="sort('status')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.deal_status') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'status' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'status' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell cursor-pointer select-none"
                            @click="sort('amount')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.deal_amount') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'amount' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'amount' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden xl:table-cell">{{ __('messages.updated_by') }}</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50" x-ref="tbody">
                    @forelse($deals as $deal)
                    <tr class="{{ $deal->trashed() ? 'opacity-50' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700/30 transition"
                        data-search="{{ strtolower($deal->id . ' ' . $deal->title . ' ' . ($deal->client?->name ?? '') . ' ' . ($deal->status?->name ?? '')) }}"
                        data-id="{{ $deal->id }}"
                        data-title="{{ $deal->title }}"
                        data-client="{{ $deal->client?->name }}"
                        data-status="{{ $deal->status?->name }}"
                        data-amount="{{ $deal->amount }}">
                        <td class="px-4 py-3 text-gray-400 dark:text-gray-500 text-xs font-mono">{{ $deal->id }}</td>
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
                                    <form method="POST" action="{{ route('deals.restore', $deal->id) }}"
                                          x-data @submit.prevent="$dispatch('confirm-action', { form: $el })">
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
                                          x-data @submit.prevent="$dispatch('confirm-action', { form: $el })">
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
                        <td colspan="7" class="px-4 py-12 text-center text-gray-400 dark:text-gray-500">{{ __('messages.no_data') }}</td>
                    </tr>
                    @endforelse
                    {{-- No results after client-side filtering --}}
                    @if($deals->count())
                    <tr x-show="search !== '' && visibleCount === 0" style="display:none">
                        <td colspan="7" class="px-4 py-12 text-center text-gray-400 dark:text-gray-500">
                            {{ __('messages.no_data') }}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if($deals->hasPages())
        <div class="mt-4">
            {{ $deals->links() }}
        </div>
        @endif
    </div>

    <x-confirm-modal />
</x-layout>
