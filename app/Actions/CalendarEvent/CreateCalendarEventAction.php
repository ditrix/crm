<?php

declare(strict_types=1);

namespace App\Actions\CalendarEvent;

use App\Http\Requests\CalendarEvent\StoreCalendarEventRequest;
use App\Models\CalendarEvent;

final class CreateCalendarEventAction
{
    public function execute(StoreCalendarEventRequest $request): CalendarEvent
    {
        return CalendarEvent::create([
            'user_id' => $request->user()->id,
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'starts_at' => $request->validated('starts_at'),
            'ends_at' => $request->validated('ends_at'),
            'all_day' => $request->boolean('all_day'),
        ]);
    }
}
