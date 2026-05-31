<x-layout>
    <x-slot name="heading">{{ __('messages.clients') }}</x-slot>

    {{-- Flash messages --}}
    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center gap-3 mb-5">
        {{-- Search --}}
        <form method="GET" action="{{ route('clients.index') }}" class="flex-1 min-w-0 flex items-center gap-2">
            @foreach(request()->except(['search','page']) as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
            <div class="relative flex-1 max-w-xs">
                <x-icon name="magnifying-glass" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="{{ __('messages.search') }}…"
                       class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            {{-- Status filter --}}
            <select name="status" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">{{ __('messages.all_statuses') }}</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" @selected(request('status') == $status->id)>{{ $status->name }}</option>
                @endforeach
            </select>

            @if(auth()->user()->isAdmin() || auth()->user()->isHead())
            {{-- Manager filter --}}
            <select name="manager" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">{{ __('messages.all_managers') }}</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" @selected(request('manager') == $manager->id)>{{ $manager->name }}</option>
                @endforeach
            </select>
            @endif
        </form>

        <x-archive-toggle :showArchived="$showArchived" route="clients.index" />

        @can('create', \App\Models\Client::class)
        <a href="{{ route('clients.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
            <x-icon name="plus" class="w-4 h-4" />
            {{ __('messages.add_client') }}
        </a>
        @endcan
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-700 text-left">
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.client_name') }}</th>
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ __('messages.client_phone') }}</th>
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell">{{ __('messages.client_status') }}</th>
                    @if(auth()->user()->isAdmin() || auth()->user()->isHead())
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell">{{ __('messages.client_manager') }}</th>
                    @endif
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden xl:table-cell">{{ __('messages.updated_by') }}</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                @forelse($clients as $client)
                <tr class="{{ $client->trashed() ? 'opacity-50' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($client->avatar)
                                <img src="{{ asset('storage/'.$client->avatar) }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">{{ strtoupper(substr($client->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $client->name }}</p>
                                @if($client->company)
                                    <p class="text-xs text-gray-400">{{ $client->company }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ $client->phone ?? '—' }}</td>
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
                                <form method="POST" action="{{ route('clients.restore', $client->id) }}">
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
                                      x-data
                                      @submit.prevent="if(confirm('{{ __('messages.confirm_delete') }}')) $el.submit()">
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
                    <td colspan="6" class="px-4 py-12 text-center text-gray-400 dark:text-gray-500">
                        {{ __('messages.no_data') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($clients->hasPages())
    <div class="mt-4">{{ $clients->links() }}</div>
    @endif
</x-layout>
