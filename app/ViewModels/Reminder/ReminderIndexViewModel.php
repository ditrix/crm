<?php

declare(strict_types=1);

namespace App\ViewModels\Reminder;

use App\Models\User;
use App\Services\Reminder\ReminderService;

final class ReminderIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(ReminderService $service, User $user): self
    {
        return new self([
            'reminders' => $service->listForUser($user),
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
