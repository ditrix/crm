<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Models\Client;
use App\Models\Deal;
use App\Models\User;
use App\Support\Cache\CacheKey;
use Illuminate\Support\Facades\Cache;

final class CacheInvalidator
{
    public function forgetClient(Client $client, ?int $previousManagerId = null): void
    {
        Cache::forget(CacheKey::clientShow($client->id));

        $managerIds = array_filter(array_unique([
            $client->manager_id,
            $previousManagerId,
        ]));

        foreach ($managerIds as $managerId) {
            $this->forgetManagerScopedCaches($managerId);
        }
    }

    public function forgetDeal(Deal $deal): void
    {
        Cache::forget(CacheKey::dealShow($deal->id));

        $clientId = $deal->client_id ?? $deal->client?->id;

        if ($clientId !== null) {
            Cache::forget(CacheKey::clientShow((int) $clientId));
        }

        $managerId = $deal->relationLoaded('client')
            ? $deal->client?->manager_id
            : Client::query()->whereKey($clientId)->value('manager_id');

        if ($managerId !== null) {
            $this->forgetManagerScopedCaches((int) $managerId);
        }
    }

    public function forgetClientStatuses(): void
    {
        Cache::forget(CacheKey::clientStatusesOrdered());
        Cache::forget(CacheKey::clientStatusesAll());
        Cache::forget(CacheKey::clientStatusSlugMap());
    }

    public function forgetDealStatuses(): void
    {
        Cache::forget(CacheKey::dealStatusesOrdered());
        Cache::forget(CacheKey::dealStatusesAll());
        Cache::forget(CacheKey::dealStatusSlugMap());
    }

    public function forgetManagers(): void
    {
        Cache::forget(CacheKey::activeManagers());
    }

    public function forgetDashboardMetrics(int $userId): void
    {
        Cache::forget(CacheKey::dashboardMetrics($userId));
    }

    public function forgetClientsByStatusId(int $statusId): void
    {
        Client::query()
            ->where('client_status_id', $statusId)
            ->get(['id', 'manager_id'])
            ->each(function (Client $client): void {
                Cache::forget(CacheKey::clientShow($client->id));

                if ($client->manager_id !== null) {
                    $this->forgetManagerScopedCaches((int) $client->manager_id);
                }
            });
    }

    public function forgetDealsByStatusId(int $statusId): void
    {
        Deal::query()
            ->where('deal_status_id', $statusId)
            ->with('client:id,manager_id')
            ->get(['id', 'client_id'])
            ->each(fn (Deal $deal) => $this->forgetDeal($deal));
    }

    public function invalidateUserRoles(User $user): void
    {
        Cache::forever(CacheKey::userRolesVersion($user->id), now()->timestamp);

        if (auth()->check() && auth()->id() === $user->id) {
            $this->applyUserRolesToSession($user);
        }
    }

    public function applyUserRolesToSession(User $user): void
    {
        session([
            'auth.roles' => $user->getRoleNames()->all(),
            'auth.roles_version' => Cache::get(CacheKey::userRolesVersion($user->id)),
        ]);
    }

    private function forgetManagerScopedCaches(int $managerId): void
    {
        Cache::forget(CacheKey::dashboardMetrics($managerId));
        Cache::forget(CacheKey::dealFormClients($managerId));
    }
}
