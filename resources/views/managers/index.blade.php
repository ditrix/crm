<x-layout>
    <x-slot name="heading">{{ __('messages.managers') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-700 text-left">
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.client_name') }}</th>
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">Email</th>
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ __('messages.clients') }}</th>
                    <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.active') }}</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                @forelse($managers as $manager)
                <tr class="{{ ! $manager->is_active ? 'opacity-50' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $manager->avatarUrl() }}" class="w-8 h-8 rounded-full object-cover">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $manager->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $manager->email }}</td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ $manager->clients->count() }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $manager->is_active
                                ? 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300'
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-500' }}">
                            {{ $manager->is_active ? __('messages.active') : __('messages.inactive') }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
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
                    </td>
                </tr>

                {{-- Manager's clients sub-table --}}
                @if($manager->clients->count() > 0)
                <tr class="bg-gray-50/50 dark:bg-gray-700/20">
                    <td colspan="5" class="px-8 py-3">
                        <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1.5">
                            @foreach($manager->clients as $client)
                            <div class="flex items-center justify-between max-w-lg">
                                <a href="{{ route('clients.show', $client) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $client->name }}
                                </a>
                                <form method="POST" action="{{ route('managers.assign-client', $client) }}" class="flex items-center gap-2">
                                    @csrf
                                    <select name="manager_id" onchange="this.form.submit()"
                                            class="px-2 py-1 rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                        @foreach($managers as $m)
                                            <option value="{{ $m->id }}" @selected($m->id === $manager->id)>{{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center text-gray-400 dark:text-gray-500">{{ __('messages.no_data') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
