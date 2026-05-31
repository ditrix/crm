<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(): View
    {
        $events = CalendarEvent::where('user_id', auth()->id())
            ->orderBy('starts_at')
            ->get();

        return view('tools.calendar', compact('events'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'starts_at'   => ['required', 'date'],
            'ends_at'     => ['nullable', 'date', 'after_or_equal:starts_at'],
            'description' => ['nullable', 'string'],
            'all_day'     => ['boolean'],
        ]);

        CalendarEvent::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description,
            'starts_at'   => $request->starts_at,
            'ends_at'     => $request->ends_at,
            'all_day'     => $request->boolean('all_day'),
        ]);

        return back()->with('success', __('messages.event_created'));
    }

    public function destroy(CalendarEvent $calendarEvent): RedirectResponse
    {
        abort_unless($calendarEvent->user_id === auth()->id(), 403);

        $calendarEvent->delete();

        return back()->with('success', __('messages.event_deleted'));
    }
}
