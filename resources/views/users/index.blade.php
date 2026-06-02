<x-layout>
    <x-slot name="heading">{{ __('messages.users') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="mb-4">
        <a href="{{ route('users.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
            <x-icon name="plus" class="w-4 h-4" />
            {{ __('messages.user_add') }}
        </a>
    </div>

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
                                {{ __('messages.name') }}
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'name' && sortDir === 'asc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 6l5-6 5 6z"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortField === 'name' && sortDir === 'desc' ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">Email</th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.role') }}</th>
                        <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.status') }}</th>
                        <th class="px-4 py-3 w-20"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50" x-ref="tbody">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition"
                        data-search="{{ strtolower($user->id . ' ' . $user->name . ' ' . $user->email) }}"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}">
                        <td class="px-4 py-3 text-gray-400 dark:text-gray-500 text-xs font-mono">{{ $user->id }}</td>
                        <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatarUrl() }}" class="w-8 h-8 rounded-xl object-cover bg-gray-200 dark:bg-gray-700" alt="">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $user->isAdmin() ? 'bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300' :
                               ($user->isHead() ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300' :
                               'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400') }}">
                            {{ $user->getRoleNames()->first() ?? '—' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($user->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300">
                                {{ __('messages.active') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/40 text-red-500 dark:text-red-400">
                                {{ __('messages.inactive') }}
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        @if(auth()->user()->id !== $user->id)
                        <a href="{{ route('users.edit', $user) }}"
                            class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400 inline-flex">
                            <x-icon name="pencil" class="w-4 h-4" />
                        </a>
                        @endif
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-layout>
