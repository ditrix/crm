<x-layout>
    <x-slot name="heading">{{ __('messages.calendar') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="max-w-2xl space-y-5">

        {{-- Add event form --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5">
            <form method="POST" action="{{ route('tools.calendar.store') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="md:col-span-2">
                        <input type="text" name="title" placeholder="{{ __('messages.event_title') }}…" required
                               value="{{ old('title') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.event_starts') }}</label>
                        <input type="datetime-local" name="starts_at" required value="{{ old('starts_at') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.event_ends') }}</label>
                        <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="md:col-span-2 flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                            <input type="checkbox" name="all_day" value="1" @checked(old('all_day'))
                                   class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500">
                            {{ __('messages.event_all_day') }}
                        </label>
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
                            {{ __('messages.event_add') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Events list --}}
        <div class="space-y-2">
            @php $today = now()->startOfDay(); $grouped = $events->groupBy(fn($e) => $e->starts_at->format('Y-m-d')); @endphp

            @forelse($grouped as $date => $dayEvents)
            <div>
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase px-1 mb-1.5">
                    {{ \Carbon\Carbon::parse($date)->isToday() ? __('messages.today_tasks') : \Carbon\Carbon::parse($date)->format('d F Y') }}
                </p>
                @foreach($dayEvents as $event)
                <div class="flex items-start gap-3 bg-white dark:bg-gray-800 rounded-2xl shadow-sm px-4 py-3 mb-2">
                    <div class="flex-shrink-0 w-10 text-center">
                        <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400 leading-none">
                            {{ $event->starts_at->format('d') }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $event->starts_at->format('H:i') }}</p>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $event->title }}</p>
                        @if($event->ends_at)
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                → {{ $event->ends_at->format('H:i') }}
                                @if($event->all_day) · {{ __('messages.event_all_day') }} @endif
                            </p>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('tools.calendar.destroy', $event) }}"
                          x-data
                          @submit.prevent="if(confirm('{{ __('messages.confirm_delete') }}')) $el.submit()">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="p-1 rounded-lg text-gray-300 dark:text-gray-600 hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                            <x-icon name="trash" class="w-4 h-4" />
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @empty
            <div class="text-center py-12 text-gray-400 dark:text-gray-500 text-sm">
                {{ __('messages.no_data') }}
            </div>
            @endforelse
        </div>
    </div>
</x-layout>
