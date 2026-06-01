<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $showAll = $request->boolean('all');

        $tasks = Task::where('user_id', auth()->id())
            ->when(! $showAll, fn ($q) => $q->pending())
            ->orderByRaw('completed_at IS NULL DESC')
            ->orderBy('due_date')
            ->get();

        return view('tools.tasks', compact('tasks', 'showAll'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        Task::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'due_date'    => $request->due_date,
            'description' => $request->description,
        ]);

        return back()->with('success', __('messages.task_created'));
    }

    public function toggle(Task $task): RedirectResponse
    {
        abort_unless($task->user_id === auth()->id(), 403);

        $task->update([
            'completed_at' => $task->completed_at ? null : now(),
        ]);

        return back();
    }

    public function destroy(Task $task): RedirectResponse
    {
        abort_unless($task->user_id === auth()->id(), 403);

        $task->delete();

        return back()->with('success', __('messages.task_deleted'));
    }
}
