@props(['showArchived' => false, 'route' => null])

@php $route ??= request()->route()->getName(); @endphp

<a href="{{ route($route, array_merge(request()->except(['archived', 'page']), $showArchived ? [] : ['archived' => 1])) }}"
   class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition
          {{ $showArchived
              ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300 hover:bg-amber-200 dark:hover:bg-amber-900/60'
              : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
    <x-icon name="archive" class="w-4 h-4" />
    {{ $showArchived ? __('messages.hide_archived') : __('messages.show_archived') }}
</a>
