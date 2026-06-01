<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReminderController extends Controller
{
    public function index(): View
    {
        $reminders = Reminder::where('user_id', auth()->id())
            ->orderBy('remind_at')
            ->get();

        return view('tools.reminders', compact('reminders'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'message'   => ['required', 'string', 'max:255'],
            'remind_at' => ['required', 'date'],
        ]);

        Reminder::create([
            'user_id'   => auth()->id(),
            'message'   => $request->message,
            'remind_at' => $request->remind_at,
        ]);

        return back()->with('success', __('messages.reminder_created'));
    }

    public function dismiss(Reminder $reminder): RedirectResponse
    {
        abort_unless($reminder->user_id === auth()->id(), 403);

        $reminder->update(['notified_at' => now()]);

        return back();
    }

    public function destroy(Reminder $reminder): RedirectResponse
    {
        abort_unless($reminder->user_id === auth()->id(), 403);

        $reminder->delete();

        return back();
    }

    /**
     * Returns pending reminders as JSON for the login notify-modal.
     */
    public function pending(): \Illuminate\Http\JsonResponse
    {
        $items = Reminder::where('user_id', auth()->id())
            ->pending()
            ->get(['id', 'message', 'remind_at']);

        return response()->json($items);
    }
}
