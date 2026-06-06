<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Models\Task;

final class ToggleTaskAction
{
    public function execute(Task $task): Task
    {
        $task->update([
            'completed_at' => $task->completed_at ? null : now(),
        ]);

        return $task;
    }
}
