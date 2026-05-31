@props(['href', 'active' => false])

<a href="{{ $href }}"
   {{ $attributes->merge([
       'class' => 'flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition '
           . ($active
               ? 'bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300'
               : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100')
   ]) }}>
    {{ $slot }}
</a>
