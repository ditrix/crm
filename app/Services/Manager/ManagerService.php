<?php

declare(strict_types=1);

namespace App\Services\Manager;

use App\Models\Client;
use App\Models\User;
use App\Services\Cache\CacheInvalidator;
use App\Services\Cache\ReferenceDataCache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class ManagerService
{
    public function __construct(
        private readonly ReferenceDataCache $referenceDataCache,
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function paginateManagers(): LengthAwarePaginator
    {
        return User::withCount('clients')
            ->role('manager')
            ->paginate(50)
            ->withQueryString();
    }

    public function loadManagerWithClients(User $user): User
    {
        return $user->load(['clients.status']);
    }

    public function getManagerOptions(): Collection
    {
        return $this->referenceDataCache->activeManagers();
    }

    public function toggleActive(User $user): User
    {
        $user->update(['is_active' => ! $user->is_active]);

        $this->cacheInvalidator->forgetManagers();

        return $user;
    }

    public function assignClient(Client $client, int $managerId): Client
    {
        $previousManagerId = $client->manager_id;

        $client->update(['manager_id' => $managerId]);

        $this->cacheInvalidator->forgetClient($client->fresh(), $previousManagerId);

        return $client;
    }
}
