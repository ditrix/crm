<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Tools;

use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\ToggleTaskAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\DestroyTaskRequest;
use App\Http\Requests\Task\IndexTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\ToggleTaskRequest;
use App\Models\Task;
use App\Services\Task\TaskService;
use App\ViewModels\Task\TaskIndexViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(IndexTaskRequest $request, TaskService $service): View
    {
        return view('tools.tasks', TaskIndexViewModel::from($service, $request)->toArray());
    }

    public function store(StoreTaskRequest $request, CreateTaskAction $action): RedirectResponse
    {
        $action->execute($request);

        return back()->with('success', __('messages.task_created'));
    }

    public function toggle(ToggleTaskRequest $request, Task $task, ToggleTaskAction $action): RedirectResponse
    {
        $action->execute($task);

        return back();
    }

    public function destroy(DestroyTaskRequest $request, Task $task, TaskService $service): RedirectResponse
    {
        $service->delete($task);

        return back()->with('success', __('messages.task_deleted'));
    }
}
