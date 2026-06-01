<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Deal;
use App\Models\Task;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user      = auth()->user();
        $isManager = $user->isManager();

        // --- Deals KPI ---
        $dealsQuery = Deal::query()
            ->when($isManager, fn ($q) => $q->forManager($user->id));

        $dealsTotal      = (clone $dealsQuery)->count();
        $dealsClosed     = (clone $dealsQuery)->withStatus('completed')->count();
        $dealsInProgress = (clone $dealsQuery)->withStatus('in_progress')->count();
        $dealsActive     = (clone $dealsQuery)->withStatus('active')->count();

        // --- Clients KPI ---
        $clientsQuery = Client::query()
            ->when($isManager, fn ($q) => $q->where('manager_id', $user->id));

        $clientsPotential   = (clone $clientsQuery)->withStatus('potential')->count();
        $clientsActive      = (clone $clientsQuery)->withStatus('active')->count();
        $clientsLoyal       = (clone $clientsQuery)->withStatus('active')->loyal()->count();

        // --- Tasks for today ---
        $tasksToday = Task::query()
            ->where('user_id', $user->id)
            ->pending()
            ->forToday()
            ->count();

        // --- Funnel data (for Vue chart) ---
        $funnelData = [
            ['label' => 'In Progress', 'count' => $dealsInProgress, 'slug' => 'in_progress'],
            ['label' => 'Active',      'count' => $dealsActive,     'slug' => 'active'],
            ['label' => 'Completed',   'count' => $dealsClosed,     'slug' => 'completed'],
        ];

        return view('dashboard.index', compact(
            'dealsTotal', 'dealsClosed', 'dealsInProgress', 'dealsActive',
            'clientsPotential', 'clientsActive', 'clientsLoyal',
            'tasksToday', 'funnelData'
        ));
    }
}
