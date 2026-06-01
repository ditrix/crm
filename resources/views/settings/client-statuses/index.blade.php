<x-layout>
    <x-slot name="heading">{{ __('messages.client_statuses') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
        {{-- Add form --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5">
                <h3 class="font-medium text-gray-900 dark:text-white mb-4">{{ __('messages.status_add') }}</h3>
                <form method="POST" action="{{ route('settings.client-statuses.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.status_name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                        @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.status_slug') }}</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" required placeholder="e.g. active"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                        @error('slug')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.status_sort') }}</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                    </div>
                    <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
                        {{ __('messages.save') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- List --}}
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700 text-left">
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 w-8">#</th>
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.status_name') }}</th>
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.status_slug') }}</th>
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400 w-16 text-center">{{ __('messages.status_sort') }}</th>
                            <th class="px-4 py-3 w-28"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50" x-data="{}">
                        @forelse($statuses as $status)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition {{ $status->trashed() ? 'opacity-50' : '' }}"
                            x-data="{ editing: false }">
                            <td class="px-4 py-2 text-gray-400">{{ $status->sort_order }}</td>
                            <td class="px-4 py-2">
                                <span x-show="!editing">
                                    <x-status-badge :slug="$status->slug" :name="$status->name" />
                                </span>
                                <form x-show="editing" method="POST"
                                    action="{{ route('settings.client-statuses.update', $status) }}"
                                    class="flex gap-2 items-center">
                                    @csrf @method('PATCH')
                                    <input type="text" name="name" value="{{ $status->name }}" required
                                        class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-2 py-1 text-xs dark:text-white w-32">
                                    <input type="hidden" name="slug" value="{{ $status->slug }}">
                                    <input type="hidden" name="sort_order" value="{{ $status->sort_order }}">
                                    <button type="submit" class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">{{ __('messages.save') }}</button>
                                </form>
                            </td>
                            <td class="px-4 py-2 font-mono text-xs text-gray-400">{{ $status->slug }}</td>
                            <td class="px-4 py-2 text-center text-gray-400">{{ $status->sort_order }}</td>
                            <td class="px-4 py-2">
                                <div class="flex items-center justify-end gap-1">
                                    @if(! $status->trashed())
                                        <button type="button" @click="editing = !editing"
                                            class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-400">
                                            <x-icon name="pencil" class="w-3.5 h-3.5" />
                                        </button>
                                        <form method="POST" action="{{ route('settings.client-statuses.destroy', $status) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('{{ __('messages.confirm_delete') }}')"
                                                class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 text-red-400">
                                                <x-icon name="trash" class="w-3.5 h-3.5" />
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('settings.client-statuses.restore', $status->id) }}">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                                {{ __('messages.restore') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">{{ __('messages.no_data') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
