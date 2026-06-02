<x-layout>
    <x-slot name="heading">{{ $user->name }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="mb-4">
        <a href="{{ route('managers.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">
            <x-icon name="chevron-left" class="w-4 h-4" />
            {{ __('messages.managers') }}
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Manager info card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 space-y-4">
            <div class="flex items-center gap-4">
                <img src="{{ $user->avatarUrl() }}" class="w-16 h-16 rounded-2xl object-cover">
                <div>
                    <h2 class="font-semibold text-lg text-gray-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $user->is_active
                            ? 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300'
                            : 'bg-gray-100 dark:bg-gray-700 text-gray-500' }}">
                        {{ $user->is_active ? __('messages.active') : __('messages.inactive') }}
                    </span>
                </div>
            </div>

            <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('messages.clients') }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $user->clients->count() }}</p>
            </div>

            <form method="POST" action="{{ route('managers.toggle', $user) }}" class="pt-1">
                @csrf
                <button type="submit"
                        class="w-full px-4 py-2 rounded-xl text-sm font-medium transition
                               {{ $user->is_active
                                   ? 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600'
                                   : 'bg-green-50 dark:bg-green-900/20 text-green-600 hover:bg-green-100' }}">
                    {{ $user->is_active ? __('messages.disable') : __('messages.enable') }}
                </button>
            </form>
        </div>

        {{-- Clients table --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-medium text-gray-900 dark:text-white">{{ __('messages.clients') }}</h3>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700 text-left">
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 w-14">ID</th>
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.client_name') }}</th>
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ __('messages.client_status') }}</th>
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.assign_manager') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                        @forelse($user->clients as $client)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                            <td class="px-4 py-3 text-xs font-mono text-gray-400 dark:text-gray-500">{{ $client->id }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($client->avatar)
                                        <img src="{{ asset('storage/'.$client->avatar) }}" class="w-7 h-7 rounded-full object-cover flex-shrink-0" alt="">
                                    @else
                                        <img src="{{ asset('images/no_image_icon.svg') }}" class="w-7 h-7 rounded-full opacity-40 flex-shrink-0" alt="">
                                    @endif
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $client->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                <x-status-badge :slug="$client->status?->slug" :name="$client->status?->name" />
                            </td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('managers.assign-client', $client) }}" class="flex items-center">
                                    @csrf
                                    <select name="manager_id" onchange="this.form.submit()"
                                            class="px-2 py-1 rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                        @foreach($managers as $m)
                                            <option value="{{ $m->id }}" {{ $m->id === $user->id ? 'selected' : '' }}>
                                                {{ $m->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('clients.show', $client) }}"
                                   class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition inline-flex">
                                    <x-icon name="eye" class="w-4 h-4" />
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">{{ __('messages.no_data') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
