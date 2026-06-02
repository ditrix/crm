<x-layout>
    <x-slot name="heading">{{ __('messages.clients') }}</x-slot>

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

                @if(auth()->user()->isAdmin() || auth()->user()->isHead())
                {{-- Manager filter --}}
                <select @change="updateFilter('manager', $event.target.value)"
                        class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">{{ __('messages.all_managers') }}</option>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}" {{ request('manager') == $manager->id ? 'selected' : '' }}>
                            {{ $manager->name }}
                        </option>
                    @endforeach
                </select>
                @endif
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

                @can('create', \App\Models\Client::class)
                <a href="{{ route('clients.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
                    <x-icon name="plus" class="w-4 h-4" />
                    {{ __('messages.add_client') }}
                </a>
                @endcan
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700 text-left">
                        {{-- Sortable headers --}}
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
                            @click="sort('name')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.client_name') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5 transition-opacity" :class="sortField === 'name' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5 transition-opacity" :class="sortField === 'name' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden md:table-cell cursor-pointer select-none"
                            @click="sort('email')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.client_email') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'email' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'email' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell cursor-pointer select-none"
                            @click="sort('phone')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.client_phone') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'phone' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'phone' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell cursor-pointer select-none"
                            @click="sort('status')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.client_status') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'status' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'status' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        @if(auth()->user()->isAdmin() || auth()->user()->isHead())
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell cursor-pointer select-none"
                            @click="sort('manager')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.client_manager') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'manager' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'manager' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        @endif
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden xl:table-cell">{{ __('messages.updated_by') }}</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50" x-ref="tbody">
                    @forelse($clients as $client)
                    <tr class="{{ $client->trashed() ? 'opacity-50' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700/30 transition"
                        data-search="{{ strtolower($client->id . ' ' . $client->name . ' ' . $client->email . ' ' . $client->phone . ' ' . $client->company . ' ' . ($client->status?->name ?? '') . ' ' . ($client->manager?->name ?? '')) }}"
                        data-id="{{ $client->id }}"
                        data-name="{{ $client->name }}"
                        data-email="{{ strtolower($client->email ?? '') }}"
                        data-phone="{{ $client->phone }}"
                        data-status="{{ $client->status?->name }}"
                        data-manager="{{ $client->manager?->name }}">
                        <td class="px-4 py-3 text-gray-400 dark:text-gray-500 text-xs font-mono">{{ $client->id }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($client->avatar)
                                    <img src="{{ asset('storage/'.$client->avatar) }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="">
                                @else
                                    <img src="{{ asset('images/no_image_icon.svg') }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0 opacity-40" alt="">
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $client->name }}</p>
                                    @if($client->company)
                                        <p class="text-xs text-gray-400">{{ $client->company }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ $client->email ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 hidden lg:table-cell">{{ $client->phone ?? '—' }}</td>
                        <td class="px-4 py-3 hidden lg:table-cell">
                            <x-status-badge :slug="$client->status?->slug" :name="$client->status?->name" />
                        </td>
                        @if(auth()->user()->isAdmin() || auth()->user()->isHead())
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 hidden lg:table-cell">{{ $client->manager?->name ?? '—' }}</td>
                        @endif
                        <td class="px-4 py-3 hidden xl:table-cell">
                            <x-updated-by :user="$client->updatedBy" :date="$client->updated_at" />
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                @if($client->trashed())
                                    @can('restore', $client)
                                    <form method="POST" action="{{ route('clients.restore', $client->id) }}"
                                          x-data @submit.prevent="$dispatch('confirm-action', { form: $el })">
                                        @csrf
                                        <button type="submit" title="{{ __('messages.restore') }}"
                                                class="p-1.5 rounded-lg text-green-500 hover:bg-green-50 dark:hover:bg-green-900/20 transition">
                                            <x-icon name="arrow-uturn-left" class="w-4 h-4" />
                                        </button>
                                    </form>
                                    @endcan
                                @else
                                    <a href="{{ route('clients.show', $client) }}" title="{{ __('messages.view') }}"
                                       class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <x-icon name="eye" class="w-4 h-4" />
                                    </a>
                                    @can('update', $client)
                                    <a href="{{ route('clients.edit', $client) }}" title="{{ __('messages.edit') }}"
                                       class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                        <x-icon name="pencil" class="w-4 h-4" />
                                    </a>
                                    @endcan
                                    @can('delete', $client)
                                    <form method="POST" action="{{ route('clients.destroy', $client) }}"
                                          x-data @submit.prevent="$dispatch('confirm-action', { form: $el })">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="{{ __('messages.delete') }}"
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
                        <td colspan="9" class="px-4 py-12 text-center text-gray-400 dark:text-gray-500">
                            {{ __('messages.no_data') }}
                        </td>
                    </tr>
                    @endforelse
                    {{-- No results after client-side filtering --}}
                    @if($clients->count())
                    <tr x-show="search !== '' && visibleCount === 0" style="display:none">
                        <td colspan="9" class="px-4 py-12 text-center text-gray-400 dark:text-gray-500">
                            {{ __('messages.no_data') }}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
        <div class="mt-4">
            {{ $clients->links() }}
        </div>
        @endif
    </div>

    <x-confirm-modal />
</x-layout>
