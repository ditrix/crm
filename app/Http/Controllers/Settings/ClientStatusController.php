<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StatusRequest;
use App\Models\ClientStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientStatusController extends Controller
{
    public function index(): View
    {
        $statuses = ClientStatus::withTrashed()->ordered()->get();

        return view('settings.client-statuses.index', compact('statuses'));
    }

    public function store(StatusRequest $request): RedirectResponse
    {
        ClientStatus::create($request->validated());

        return back()->with('success', __('messages.status_created'));
    }

    public function update(StatusRequest $request, ClientStatus $clientStatus): RedirectResponse
    {
        $clientStatus->update($request->validated());

        return back()->with('success', __('messages.status_updated'));
    }

    public function destroy(ClientStatus $clientStatus): RedirectResponse
    {
        $clientStatus->delete();

        return back()->with('success', __('messages.status_deleted'));
    }

    public function restore(int $id): RedirectResponse
    {
        ClientStatus::withTrashed()->findOrFail($id)->restore();

        return back()->with('success', __('messages.status_restored'));
    }
}
