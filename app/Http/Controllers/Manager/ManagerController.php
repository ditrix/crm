<?php

declare(strict_types=1);

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerController extends Controller
{
    public function index(): View
    {
        $this->authorizeForHeadOrAdmin();

        $managers = User::withCount('clients')
            ->role('manager')
            ->get();

        return view('managers.index', compact('managers'));
    }

    public function show(User $user): View
    {
        $this->authorizeForHeadOrAdmin();

        $user->load(['clients.status']);
        $managers = User::role('manager')->get(['id', 'name']);

        return view('managers.show', compact('user', 'managers'));
    }

    public function toggle(User $user): RedirectResponse
    {
        $this->authorizeForHeadOrAdmin();

        $user->update(['is_active' => ! $user->is_active]);

        $message = $user->is_active
            ? __('messages.manager_enabled')
            : __('messages.manager_disabled');

        return back()->with('success', $message);
    }

    public function assignClient(Request $request, Client $client): RedirectResponse
    {
        $this->authorizeForHeadOrAdmin();

        $request->validate([
            'manager_id' => ['required', 'exists:users,id'],
        ]);

        $client->update(['manager_id' => $request->manager_id]);

        return back()->with('success', __('messages.manager_assigned'));
    }

    private function authorizeForHeadOrAdmin(): void
    {
        abort_unless(
            auth()->user()->isAdmin() || auth()->user()->isHead(),
            403
        );
    }
}
