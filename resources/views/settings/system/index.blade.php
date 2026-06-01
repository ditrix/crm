<x-layout>
    <x-slot name="heading">{{ __('messages.settings') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- System settings --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
                <h2 class="font-semibold text-gray-900 dark:text-white mb-5">{{ __('messages.system_settings') }}</h2>
                <form method="POST" action="{{ route('settings.update') }}" class="space-y-4">
                    @csrf @method('PATCH')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.app_name') }}</label>
                        <input type="text" name="app_name" value="{{ old('app_name', $settings['app_name']) }}" required
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                        @error('app_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.default_locale') }}</label>
                        <select name="default_locale"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                            <option value="en" {{ $settings['default_locale'] === 'en' ? 'selected' : '' }}>English</option>
                            <option value="ua" {{ $settings['default_locale'] === 'ua' ? 'selected' : '' }}>Українська</option>
                            <option value="ru" {{ $settings['default_locale'] === 'ru' ? 'selected' : '' }}>Русский</option>
                        </select>
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                            class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Quick links to directories --}}
        <div class="space-y-3">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider px-1">
                {{ __('messages.directories') }}
            </h3>
            <a href="{{ route('settings.client-statuses.index') }}"
                class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700/60 transition group">
                <x-icon name="users" class="w-5 h-5 text-indigo-500" />
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                    {{ __('messages.client_statuses') }}
                </span>
            </a>
            <a href="{{ route('settings.deal-statuses.index') }}"
                class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700/60 transition group">
                <x-icon name="briefcase" class="w-5 h-5 text-indigo-500" />
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                    {{ __('messages.deal_statuses') }}
                </span>
            </a>
        </div>
    </div>
</x-layout>
