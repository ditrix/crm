<?php

declare(strict_types=1);

namespace App\Actions\Reminder;

use App\Http\Requests\Reminder\StoreReminderRequest;
use App\Models\Reminder;

final class CreateReminderAction
{
    public function execute(StoreReminderRequest $request): Reminder
    {
        return Reminder::create([
            'user_id' => $request->user()->id,
            'message' => $request->validated('message'),
            'remind_at' => $request->validated('remind_at'),
        ]);
    }
}
