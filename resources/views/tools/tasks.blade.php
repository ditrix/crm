<x-layout>
    <x-slot name="heading">{{ __('messages.tasks') }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="max-w-2xl space-y-5">

        {{-- Add task form --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5">
            <form method="POST" action="{{ route('tools.tasks.store') }}" class="space-y-3">
                @csrf
                <div class="flex gap-3">
                    <input type="text" name="title" placeholder="{{ __('messages.task_title') }}…" required
                           value="{{ old('title') }}"
                           class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <input type="date" name="due_date" value="{{ old('due_date') }}"
                           class="px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit"
                            class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition whitespace-nowrap">
                        {{ __('messages.task_add') }}
                    </button>
                </div>
                <textarea name="description" rows="2" placeholder="{{ __('messages.task_description') }}…"
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('description') }}</textarea>
            </form>
        </div>

        {{-- Filter --}}
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ $tasks->count() }} {{ __('messages.tasks') }}
            </span>
            <a href="{{ route('tools.tasks', $showAll ? [] : ['all' => 1]) }}"
               class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                {{ $showAll ? __('messages.hide_completed') : __('messages.show_completed') }}
            </a>
        </div>

        {{-- Task list --}}
        <div class="space-y-2">
            @forelse($tasks as $task)
            <div class="flex items-start gap-3 bg-white dark:bg-gray-800 rounded-2xl shadow-sm px-4 py-3
                        {{ $task->isCompleted() ? 'opacity-60' : '' }}">

                {{-- Toggle complete --}}
                <form method="POST" action="{{ route('tools.tasks.toggle', $task) }}" class="mt-0.5">
                    @csrf
                    <button type="submit"
                            class="w-5 h-5 rounded-full border-2 flex-shrink-0 transition
                                   {{ $task->isCompleted()
                                       ? 'bg-indigo-500 border-indigo-500'
                                       : 'border-gray-300 dark:border-gray-600 hover:border-indigo-400' }}">
                        @if($task->isCompleted())
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full p-0.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        @endif
                    </button>
                </form>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white {{ $task->isCompleted() ? 'line-through' : '' }}">
                        {{ $task->title }}
                    </p>
                    @if($task->description)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $task->description }}</p>
                    @endif
                    @if($task->due_date)
                        <p class="text-xs mt-1 {{ $task->due_date->isPast() && ! $task->isCompleted() ? 'text-red-500' : 'text-gray-400 dark:text-gray-500' }}">
                            {{ $task->due_date->format('d.m.Y') }}
                        </p>
                    @endif
                </div>

                {{-- Delete --}}
                <form method="POST" action="{{ route('tools.tasks.destroy', $task) }}"
                      x-data
                      @submit.prevent="if(confirm('{{ __('messages.confirm_delete') }}')) $el.submit()">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="p-1 rounded-lg text-gray-300 dark:text-gray-600 hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                        <x-icon name="trash" class="w-4 h-4" />
                    </button>
                </form>
            </div>
            @empty
            <div class="text-center py-12 text-gray-400 dark:text-gray-500 text-sm">
                {{ __('messages.no_data') }}
            </div>
            @endforelse
        </div>
    </div>
</x-layout>
