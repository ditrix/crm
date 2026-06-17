<?php

declare(strict_types=1);

namespace App\Http\Requests\CalendarEvent;

use App\Models\CalendarEvent;
use Illuminate\Foundation\Http\FormRequest;

class DestroyCalendarEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var CalendarEvent $calendarEvent */
        $calendarEvent = $this->route('calendarEvent');

        return $calendarEvent->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [];
    }
}
