<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Http\Requests\Task\IndexTaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

final class TaskService
{
    public function listForUser(IndexTaskRequest $request): Collection
    {
        $showAll = $request->boolean('all');

        return Task::where('user_id', $request->user()->id)
            ->when(! $showAll, fn ($q) => $q->pending())
            ->orderByRaw('completed_at IS NULL DESC')
            ->orderBy('due_date')
            ->get();
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
