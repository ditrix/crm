<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateSystemSettingsRequest;
use App\Services\Settings\SystemSettingsService;
use App\ViewModels\Settings\SystemSettingsIndexViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SystemSettingsController extends Controller
{
    public function index(SystemSettingsService $service): View
    {
        return view('settings.system.index', SystemSettingsIndexViewModel::from($service)->toArray());
    }

    public function update(UpdateSystemSettingsRequest $request, SystemSettingsService $service): RedirectResponse
    {
        $service->update($request->validated());

        return back()->with('success', __('messages.settings_saved'));
    }
}
