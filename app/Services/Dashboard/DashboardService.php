<?php

declare(strict_types=1);

namespace App\Services\Dashboard;

use App\Models\Client;
use App\Models\ClientStatus;
use App\Models\Deal;
use App\Models\DealStatus;
use App\Models\Task;
use App\Models\User;

final class DashboardService
{
    public function getMetrics(User $user): array
    {
        $isManager = $user->isManager();

        $dealsQuery = Deal::query()
            ->when($isManager, fn ($q) => $q->forManager($user->id));

        $dealsTotal = (clone $dealsQuery)->count();
        $dealsClosed = (clone $dealsQuery)->withStatus('completed')->count();
        $dealsInProgress = (clone $dealsQuery)->withStatus('in_progress')->count();
        $dealsActive = (clone $dealsQuery)->withStatus('active')->count();

        $clientsQuery = Client::query()
            ->when($isManager, fn ($q) => $q->where('manager_id', $user->id));

        $clientsPotential = (clone $clientsQuery)->withStatus('potential')->count();
        $clientsActive = (clone $clientsQuery)->withStatus('active')->count();
        $clientsLoyal = (clone $clientsQuery)->withStatus('active')->loyal()->count();

        $tasksToday = Task::query()
            ->where('user_id', $user->id)
            ->pending()
            ->forToday()
            ->count();

        $funnelData = [
            ['label' => 'In Progress', 'count' => $dealsInProgress, 'slug' => 'in_progress'],
            ['label' => 'Active', 'count' => $dealsActive, 'slug' => 'active'],
            ['label' => 'Completed', 'count' => $dealsClosed, 'slug' => 'completed'],
        ];

        return [
            'dealsTotal' => $dealsTotal,
            'dealsClosed' => $dealsClosed,
            'dealsInProgress' => $dealsInProgress,
            'dealsActive' => $dealsActive,
            'clientsPotential' => $clientsPotential,
            'clientsActive' => $clientsActive,
            'clientsLoyal' => $clientsLoyal,
            'tasksToday' => $tasksToday,
            'funnelData' => $funnelData,
            'dealStatusLinks' => [
                'in_progress' => DealStatus::bySlug('in_progress')->value('id'),
                'active' => DealStatus::bySlug('active')->value('id'),
                'completed' => DealStatus::bySlug('completed')->value('id'),
            ],
            'clientStatusLinks' => [
                'potential' => ClientStatus::bySlug('potential')->value('id'),
                'active' => ClientStatus::bySlug('active')->value('id'),
            ],
        ];
    }
}
