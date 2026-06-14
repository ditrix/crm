<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\RestoreStatusRequest;
use App\Http\Requests\Settings\StatusRequest;
use App\Models\ClientStatus;
use App\Services\Settings\ClientStatusService;
use App\ViewModels\Settings\ClientStatusIndexViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientStatusController extends Controller
{
    public function index(ClientStatusService $service): View
    {
        return view('settings.client-statuses.index', ClientStatusIndexViewModel::from($service)->toArray());
    }

    public function store(StatusRequest $request, ClientStatusService $service): RedirectResponse
    {
        $service->create($request->validated());

        return back()->with('success', __('messages.status_created'));
    }

    public function update(StatusRequest $request, ClientStatus $clientStatus, ClientStatusService $service): RedirectResponse
    {
        $service->update($clientStatus, $request->validated());

        return back()->with('success', __('messages.status_updated'));
    }

    public function destroy(ClientStatus $clientStatus, ClientStatusService $service): RedirectResponse
    {
        $service->delete($clientStatus);

        return back()->with('success', __('messages.status_deleted'));
    }

    public function restore(RestoreStatusRequest $request, ClientStatusService $service): RedirectResponse
    {
        $service->restore((int) $request->validated('id'));

        return back()->with('success', __('messages.status_restored'));
    }
}
