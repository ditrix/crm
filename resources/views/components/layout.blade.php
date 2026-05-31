@props(['heading' => ''])

<x-layouts.app :heading="$heading">
    {{ $slot }}
</x-layouts.app>
