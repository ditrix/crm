<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StatusRequest;
use App\Models\DealStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DealStatusController extends Controller
{
    public function index(): View
    {
        $statuses = DealStatus::withTrashed()->ordered()->get();

        return view('settings.deal-statuses.index', compact('statuses'));
    }

    public function store(StatusRequest $request): RedirectResponse
    {
        DealStatus::create($request->validated());

        return back()->with('success', __('messages.status_created'));
    }

    public function update(StatusRequest $request, DealStatus $dealStatus): RedirectResponse
    {
        $dealStatus->update($request->validated());

        return back()->with('success', __('messages.status_updated'));
    }

    public function destroy(DealStatus $dealStatus): RedirectResponse
    {
        $dealStatus->delete();

        return back()->with('success', __('messages.status_deleted'));
    }

    public function restore(int $id): RedirectResponse
    {
        DealStatus::withTrashed()->findOrFail($id)->restore();

        return back()->with('success', __('messages.status_restored'));
    }
}
