<?php

declare(strict_types=1);

namespace App\ViewModels\Task;

use App\Http\Requests\Task\IndexTaskRequest;
use App\Services\Task\TaskService;

final class TaskIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(TaskService $service, IndexTaskRequest $request): self
    {
        return new self([
            'tasks' => $service->listForUser($request),
            'showAll' => $request->boolean('all'),
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
