<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', v => localStorage.setItem('darkMode', v))"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? __('messages.app_name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col shadow-sm flex-shrink-0">
        {{-- Logo --}}
        <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-gray-700">
            <span class="text-xl font-semibold tracking-tight text-indigo-600 dark:text-indigo-400">
                {{ __('messages.app_name') }}
            </span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <x-icon name="squares-2x2" class="w-5 h-5" />
                {{ __('messages.dashboard') }}
            </x-nav-link>

            <x-nav-link :href="'#'" :active="false">
                <x-icon name="users" class="w-5 h-5" />
                {{ __('messages.clients') }}
            </x-nav-link>

            <x-nav-link :href="'#'" :active="false">
                <x-icon name="briefcase" class="w-5 h-5" />
                {{ __('messages.deals') }}
            </x-nav-link>

            @if(auth()->user()?->isAdmin() || auth()->user()?->isHead())
            <x-nav-link :href="'#'" :active="false">
                <x-icon name="user-group" class="w-5 h-5" />
                {{ __('messages.managers') }}
            </x-nav-link>

            <x-nav-link :href="'#'" :active="false">
                <x-icon name="tag" class="w-5 h-5" />
                {{ __('messages.directories') }}
            </x-nav-link>
            @endif

            <div class="pt-3 pb-1">
                <p class="px-3 text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                    {{ __('messages.tools') }}
                </p>
            </div>

            <x-nav-link :href="'#'" :active="false">
                <x-icon name="calendar" class="w-5 h-5" />
                {{ __('messages.calendar') }}
            </x-nav-link>

            <x-nav-link :href="'#'" :active="false">
                <x-icon name="pencil-square" class="w-5 h-5" />
                {{ __('messages.notes') }}
            </x-nav-link>

            <x-nav-link :href="'#'" :active="false">
                <x-icon name="check-circle" class="w-5 h-5" />
                {{ __('messages.tasks') }}
            </x-nav-link>

            @if(auth()->user()?->isAdmin())
            <div class="pt-3 pb-1">
                <p class="px-3 text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                    {{ __('messages.settings') }}
                </p>
            </div>
            <x-nav-link :href="'#'" :active="false">
                <x-icon name="cog-6-tooth" class="w-5 h-5" />
                {{ __('messages.settings') }}
            </x-nav-link>
            @endif
        </nav>

        {{-- User block --}}
        <div class="border-t border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()?->avatarUrl() }}"
                     alt="{{ auth()->user()?->name }}"
                     class="w-9 h-9 rounded-full object-cover bg-gray-200 dark:bg-gray-700">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ auth()->user()?->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ auth()->user()?->getRoleNames()->first() }}
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            title="{{ __('auth.logout') }}"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <x-icon name="arrow-right-on-rectangle" class="w-5 h-5" />
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main area --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Top header --}}
        <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6 shadow-sm flex-shrink-0">
            <h1 class="text-lg font-semibold">{{ $heading ?? '' }}</h1>

            <div class="flex items-center gap-3">
                {{-- Dark / Light toggle --}}
                <button @click="darkMode = !darkMode"
                        class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                        :title="darkMode ? '{{ __('messages.light_mode') }}' : '{{ __('messages.dark_mode') }}'">
                    <template x-if="darkMode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                    </template>
                    <template x-if="!darkMode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </template>
                </button>

                {{-- Locale switcher --}}
                <div class="flex items-center gap-1 text-sm">
                    @foreach(['en', 'ua', 'ru'] as $lang)
                    <a href="{{ route('locale.switch', $lang) }}"
                       class="px-2 py-1 rounded-md transition
                              {{ app()->getLocale() === $lang
                                  ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 font-medium'
                                  : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        {{ strtoupper($lang) }}
                    </a>
                    @endforeach
                </div>

                {{-- Profile link --}}
                <a href="#"
                   class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                   title="{{ __('messages.profile') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </a>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>
    </div>

    <script>
        // Initialize Alpine darkMode from localStorage on page load
        document.documentElement.classList.toggle(
            'dark',
            localStorage.getItem('darkMode') === 'true'
        );
    </script>
</body>
</html>
