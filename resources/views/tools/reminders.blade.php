<x-layout>
    <x-slot name="heading">{{ __('messages.reminders') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="max-w-2xl space-y-5">

        {{-- Add reminder form --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5">
            <form method="POST" action="{{ route('tools.reminders.store') }}" class="flex flex-wrap gap-3">
                @csrf
                <input type="text" name="message" placeholder="{{ __('messages.reminder_message') }}…" required
                       value="{{ old('message') }}"
                       class="flex-1 min-w-40 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <input type="datetime-local" name="remind_at" required value="{{ old('remind_at') }}"
                       class="px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit"
                        class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition whitespace-nowrap">
                    {{ __('messages.reminder_add') }}
                </button>
            </form>
        </div>

        {{-- List --}}
        <div class="space-y-2">
            @forelse($reminders as $reminder)
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 rounded-2xl shadow-sm px-4 py-3
                        {{ $reminder->notified_at ? 'opacity-50' : '' }}">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $reminder->message }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                        {{ $reminder->remind_at->format('d.m.Y H:i') }}
                        @if($reminder->notified_at)
                            · {{ __('messages.reminder_dismiss') }}d
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-1">
                    @if(! $reminder->notified_at)
                    <form method="POST" action="{{ route('tools.reminders.dismiss', $reminder) }}">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1.5 rounded-lg text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            {{ __('messages.reminder_dismiss') }}
                        </button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('tools.reminders.destroy', $reminder) }}"
                          x-data
                          @submit.prevent="if(confirm('{{ __('messages.confirm_delete') }}')) $el.submit()">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="p-1.5 rounded-lg text-gray-300 dark:text-gray-600 hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                            <x-icon name="trash" class="w-4 h-4" />
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-400 dark:text-gray-500 text-sm">{{ __('messages.no_data') }}</div>
            @endforelse
        </div>
    </div>
</x-layout>
