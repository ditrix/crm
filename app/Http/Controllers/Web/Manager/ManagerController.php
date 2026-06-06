<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\AssignClientRequest;
use App\Http\Requests\Manager\IndexManagerRequest;
use App\Http\Requests\Manager\ShowManagerRequest;
use App\Http\Requests\Manager\ToggleManagerRequest;
use App\Models\Client;
use App\Models\User;
use App\Services\Manager\ManagerService;
use App\ViewModels\Manager\ManagerIndexViewModel;
use App\ViewModels\Manager\ManagerShowViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ManagerController extends Controller
{
    public function index(IndexManagerRequest $request, ManagerService $service): View
    {
        return view('managers.index', ManagerIndexViewModel::from($service)->toArray());
    }

    public function show(ShowManagerRequest $request, User $user, ManagerService $service): View
    {
        return view('managers.show', ManagerShowViewModel::from($service, $user)->toArray());
    }

    public function toggle(ToggleManagerRequest $request, User $user, ManagerService $service): RedirectResponse
    {
        $user = $service->toggleActive($user);

        $message = $user->is_active
            ? __('messages.manager_enabled')
            : __('messages.manager_disabled');

        return back()->with('success', $message);
    }

    public function assignClient(AssignClientRequest $request, Client $client, ManagerService $service): RedirectResponse
    {
        $service->assignClient($client, (int) $request->validated('manager_id'));

        return back()->with('success', __('messages.manager_assigned'));
    }
}
