@props(['user' => null, 'date' => null])

@if($user || $date)
<span class="text-xs text-gray-400 dark:text-gray-500">
    @if($user) {{ $user->name }} @endif
    @if($date) · {{ \Carbon\Carbon::parse($date)->format('d.m.y H:i') }} @endif
</span>
@endif
