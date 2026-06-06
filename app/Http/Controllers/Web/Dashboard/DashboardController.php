<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use App\ViewModels\Dashboard\DashboardIndexViewModel;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(DashboardService $service): View
    {
        return view(
            'dashboard.index',
            DashboardIndexViewModel::from($service, auth()->user())->toArray()
        );
    }
}
