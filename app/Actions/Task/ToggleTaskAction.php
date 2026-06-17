<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Models\Task;
use App\Services\Cache\CacheInvalidator;

final class ToggleTaskAction
{
    public function __construct(
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function execute(Task $task): Task
    {
        $task->update([
            'completed_at' => $task->completed_at ? null : now(),
        ]);

        $this->cacheInvalidator->forgetDashboardMetrics($task->user_id);

        return $task;
    }
}
