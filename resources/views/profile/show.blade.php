<x-layout>
    <x-slot name="heading">{{ __('messages.profile') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 max-w-3xl">
        {{-- Personal info --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-5">{{ __('messages.personal_info') }}</h2>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PATCH')

                {{-- Avatar --}}
                <div class="flex items-center gap-4">
                    <div class="relative" x-data="{ preview: null }">
                        <img
                            :src="preview ?? '{{ $user->avatarUrl() }}'"
                            class="w-16 h-16 rounded-2xl object-cover bg-gray-200 dark:bg-gray-700"
                            alt="{{ $user->name }}"
                        >
                        <label class="absolute -bottom-1 -right-1 w-6 h-6 bg-indigo-600 hover:bg-indigo-700 rounded-full flex items-center justify-center cursor-pointer transition">
                            <x-icon name="pencil" class="w-3 h-3 text-white" />
                            <input type="file" name="avatar" accept="image/*" class="sr-only"
                                @change="preview = URL.createObjectURL($event.target.files[0])">
                        </label>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>

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

                @error('avatar')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

                <button type="submit"
                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
                    {{ __('messages.save') }}
                </button>
            </form>
        </div>

        {{-- Change password --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-5">{{ __('messages.change_password') }}</h2>

            <form method="POST" action="{{ route('profile.password') }}" class="space-y-4" x-data="{ showCurrent: false, showNew: false }">
                @csrf @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.current_password') }}</label>
                    <div class="relative">
                        <input :type="showCurrent ? 'text' : 'password'" name="current_password"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                        <button type="button" @click="showCurrent = !showCurrent"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <x-icon name="eye" class="w-4 h-4" />
                        </button>
                    </div>
                    @error('current_password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.new_password') }}</label>
                    <div class="relative">
                        <input :type="showNew ? 'text' : 'password'" name="password"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                        <button type="button" @click="showNew = !showNew"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <x-icon name="eye" class="w-4 h-4" />
                        </button>
                    </div>
                    @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.confirm_password') }}</label>
                    <input type="password" name="password_confirmation"
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                </div>

                <button type="submit"
                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
                    {{ __('messages.save') }}
                </button>
            </form>
        </div>
    </div>
</x-layout>
