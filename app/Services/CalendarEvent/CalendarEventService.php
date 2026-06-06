<?php

declare(strict_types=1);

namespace App\Services\CalendarEvent;

use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class CalendarEventService
{
    public function listForUser(User $user): Collection
    {
        return CalendarEvent::where('user_id', $user->id)
            ->orderBy('starts_at')
            ->get();
    }

    public function delete(CalendarEvent $calendarEvent): void
    {
        $calendarEvent->delete();
    }
}
