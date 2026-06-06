<?php

declare(strict_types=1);

namespace App\Actions\Reminder;

use App\Models\Reminder;

final class DismissReminderAction
{
    public function execute(Reminder $reminder): Reminder
    {
        $reminder->update(['notified_at' => now()]);

        return $reminder;
    }
}
