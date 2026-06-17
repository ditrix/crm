<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Models\Task;
use App\Services\Cache\CacheInvalidator;

final class CreateTaskAction
{
    public function __construct(
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function execute(StoreTaskRequest $request): Task
    {
        $task = Task::create([
            'user_id' => $request->user()->id,
            'title' => $request->validated('title'),
            'due_date' => $request->validated('due_date'),
            'description' => $request->validated('description'),
        ]);

        $this->cacheInvalidator->forgetDashboardMetrics($task->user_id);

        return $task;
    }
}
