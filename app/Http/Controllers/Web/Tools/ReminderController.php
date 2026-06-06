<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Tools;

use App\Actions\Reminder\CreateReminderAction;
use App\Actions\Reminder\DismissReminderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reminder\DestroyReminderRequest;
use App\Http\Requests\Reminder\DismissReminderRequest;
use App\Http\Requests\Reminder\StoreReminderRequest;
use App\Models\Reminder;
use App\Services\Reminder\ReminderService;
use App\ViewModels\Reminder\ReminderIndexViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReminderController extends Controller
{
    public function index(ReminderService $service): View
    {
        return view('tools.reminders', ReminderIndexViewModel::from($service, auth()->user())->toArray());
    }

    public function store(StoreReminderRequest $request, CreateReminderAction $action): RedirectResponse
    {
        $action->execute($request);

        return back()->with('success', __('messages.reminder_created'));
    }

    public function dismiss(DismissReminderRequest $request, Reminder $reminder, DismissReminderAction $action): RedirectResponse
    {
        $action->execute($reminder);

        return back();
    }

    public function destroy(DestroyReminderRequest $request, Reminder $reminder, ReminderService $service): RedirectResponse
    {
        $service->delete($reminder);

        return back();
    }

    public function pending(ReminderService $service): JsonResponse
    {
        return response()->json($service->pendingForUser(auth()->user()));
    }
}
