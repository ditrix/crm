<?php

declare(strict_types=1);

namespace App\Services\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class ReminderService
{
    public function listForUser(User $user): Collection
    {
        return Reminder::where('user_id', $user->id)
            ->orderBy('remind_at')
            ->get();
    }

    public function pendingForUser(User $user): Collection
    {
        return Reminder::where('user_id', $user->id)
            ->pending()
            ->get(['id', 'message', 'remind_at']);
    }

    public function delete(Reminder $reminder): void
    {
        $reminder->delete();
    }
}
