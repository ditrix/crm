<x-layout>
    <x-slot name="heading">{{ __('messages.managers') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div x-data="crmTable()">
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
                            @click="sort('name')">
                            <div class="flex items-center gap-1">
                                {{ __('messages.client_name') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'name' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'name' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">Email</th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ __('messages.clients') }}</th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.active') }}</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50" x-ref="tbody">
                    @forelse($managers as $manager)
                    <tr class="{{ ! $manager->is_active ? 'opacity-50' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700/30 transition"
                        data-search="{{ strtolower($manager->id . ' ' . $manager->name . ' ' . $manager->email) }}"
                        data-id="{{ $manager->id }}"
                        data-name="{{ $manager->name }}">
                        <td class="px-4 py-3 text-gray-400 dark:text-gray-500 text-xs font-mono">{{ $manager->id }}</td>
                        <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $manager->avatarUrl() }}" class="w-8 h-8 rounded-full object-cover">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $manager->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $manager->email }}</td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ $manager->clients_count }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $manager->is_active
                                ? 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300'
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-500' }}">
                            {{ $manager->is_active ? __('messages.active') : __('messages.inactive') }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('managers.show', $manager) }}" title="{{ __('messages.view') }}"
                               class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <x-icon name="eye" class="w-4 h-4" />
                            </a>
                            <form method="POST" action="{{ route('managers.toggle', $manager) }}">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 rounded-lg text-sm font-medium transition
                                               {{ $manager->is_active
                                                   ? 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600'
                                                   : 'bg-green-50 dark:bg-green-900/20 text-green-600 hover:bg-green-100' }}">
                                    {{ $manager->is_active ? __('messages.disable') : __('messages.enable') }}
                                </button>
                            </form>
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

        @if($managers->hasPages())
        <div class="mt-4">
            {{ $managers->links() }}
        </div>
        @endif
    </div>
</x-layout>
