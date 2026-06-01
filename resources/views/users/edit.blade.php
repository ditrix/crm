<x-layout>
    <x-slot name="heading">{{ __('messages.user_edit') }}</x-slot>

    <div class="max-w-lg">
        <div class="mb-4">
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">
                <x-icon name="chevron-left" class="w-4 h-4" />{{ __('messages.users') }}
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
            <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
                @csrf @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 px-3 py-2 text-sm text-gray-400 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.role') }}</label>
                    <select name="role" required
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                    @error('role')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ $user->is_active ? 'checked' : '' }}
                        class="rounded border-gray-300 dark:border-gray-600 text-indigo-600">
                    <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">{{ __('messages.active') }}</label>
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
                    {{ __('messages.save') }}
                </button>
            </form>
        </div>
    </div>
</x-layout>
