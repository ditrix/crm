<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Models\Task;

final class CreateTaskAction
{
    public function execute(StoreTaskRequest $request): Task
    {
        return Task::create([
            'user_id' => $request->user()->id,
            'title' => $request->validated('title'),
            'due_date' => $request->validated('due_date'),
            'description' => $request->validated('description'),
        ]);
    }
}
