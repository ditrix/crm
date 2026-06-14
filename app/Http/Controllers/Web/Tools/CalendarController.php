<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Tools;

use App\Actions\CalendarEvent\CreateCalendarEventAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalendarEvent\DestroyCalendarEventRequest;
use App\Http\Requests\CalendarEvent\StoreCalendarEventRequest;
use App\Models\CalendarEvent;
use App\Services\CalendarEvent\CalendarEventService;
use App\ViewModels\CalendarEvent\CalendarIndexViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(CalendarEventService $service): View
    {
        return view('tools.calendar', CalendarIndexViewModel::from($service, auth()->user())->toArray());
    }

    public function store(StoreCalendarEventRequest $request, CreateCalendarEventAction $action): RedirectResponse
    {
        $action->execute($request);

        return back()->with('success', __('messages.event_created'));
    }

    public function destroy(DestroyCalendarEventRequest $request, CalendarEvent $calendarEvent, CalendarEventService $service): RedirectResponse
    {
        $service->delete($calendarEvent);

        return back()->with('success', __('messages.event_deleted'));
    }
}
