<?php

declare(strict_types=1);

namespace App\ViewModels\CalendarEvent;

use App\Models\User;
use App\Services\CalendarEvent\CalendarEventService;

final class CalendarIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(CalendarEventService $service, User $user): self
    {
        return new self([
            'events' => $service->listForUser($user),
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
