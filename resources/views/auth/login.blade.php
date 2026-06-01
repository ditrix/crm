<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('auth.sign_in_to_crm') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        document.documentElement.classList.toggle(
            'dark',
            localStorage.getItem('darkMode') === 'true'
        );
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm" x-data="{ showPassword: false }">

        {{-- Dark toggle + locale --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-1 text-sm">
                @foreach(['en', 'ua', 'ru'] as $lang)
                <a href="{{ route('locale.switch', $lang) }}"
                   class="px-2.5 py-1 rounded-lg transition
                          {{ app()->getLocale() === $lang
                              ? 'bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 font-medium'
                              : 'text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                    {{ strtoupper($lang) }}
                </a>
                @endforeach
            </div>

            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                    class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
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
        </div>

        {{-- Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg shadow-gray-200/60 dark:shadow-gray-900/60 px-8 py-10">

            {{-- Header --}}
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('auth.welcome_back') }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('auth.sign_in_to_crm') }}</p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
            <div class="mb-4 px-4 py-3 rounded-2xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-sm text-red-700 dark:text-red-400">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        {{ __('auth.email') }}
                    </label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           autocomplete="email"
                           required
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-600
                                  bg-gray-50 dark:bg-gray-700/50
                                  text-gray-900 dark:text-white
                                  placeholder:text-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                  transition text-sm">
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        {{ __('auth.password_label') }}
                    </label>
                    <div class="relative">
                        <input id="password"
                               :type="showPassword ? 'text' : 'password'"
                               name="password"
                               autocomplete="current-password"
                               required
                               class="w-full px-4 py-3 pr-12 rounded-2xl border border-gray-200 dark:border-gray-600
                                      bg-gray-50 dark:bg-gray-700/50
                                      text-gray-900 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                      transition text-sm">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                :title="showPassword ? '{{ __('auth.hide_password') }}' : '{{ __('auth.show_password') }}'"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <template x-if="!showPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </template>
                            <template x-if="showPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </template>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input id="remember" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500">
                    <label for="remember" class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('auth.remember_me') }}
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
                               text-white font-medium text-sm rounded-2xl
                               transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                               dark:focus:ring-offset-gray-800 mt-2">
                    {{ __('auth.login') }}
                </button>
            </form>
        </div>
    </div>

</body>
</html>
