<?php

declare(strict_types=1);

namespace App\Services\Manager;

use App\Models\Client;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class ManagerService
{
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
        return User::role('manager')->get(['id', 'name']);
    }

    public function toggleActive(User $user): User
    {
        $user->update(['is_active' => ! $user->is_active]);

        return $user;
    }

    public function assignClient(Client $client, int $managerId): Client
    {
        $client->update(['manager_id' => $managerId]);

        return $client;
    }
}
