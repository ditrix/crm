<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\RestoreStatusRequest;
use App\Http\Requests\Settings\StatusRequest;
use App\Models\DealStatus;
use App\Services\Settings\DealStatusService;
use App\ViewModels\Settings\DealStatusIndexViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DealStatusController extends Controller
{
    public function index(DealStatusService $service): View
    {
        return view('settings.deal-statuses.index', DealStatusIndexViewModel::from($service)->toArray());
    }

    public function store(StatusRequest $request, DealStatusService $service): RedirectResponse
    {
        $service->create($request->validated());

        return back()->with('success', __('messages.status_created'));
    }

    public function update(StatusRequest $request, DealStatus $dealStatus, DealStatusService $service): RedirectResponse
    {
        $service->update($dealStatus, $request->validated());

        return back()->with('success', __('messages.status_updated'));
    }

    public function destroy(DealStatus $dealStatus, DealStatusService $service): RedirectResponse
    {
        $service->delete($dealStatus);

        return back()->with('success', __('messages.status_deleted'));
    }

    public function restore(RestoreStatusRequest $request, DealStatusService $service): RedirectResponse
    {
        $service->restore((int) $request->validated('id'));

        return back()->with('success', __('messages.status_restored'));
    }
}
