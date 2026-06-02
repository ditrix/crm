<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active;
    }

    public function view(User $user, Client $client): bool
    {
        return $this->canAccess($user, $client);
    }

    public function create(User $user): bool
    {
        return $user->is_active;
    }

    public function update(User $user, Client $client): bool
    {
        return $this->canAccess($user, $client);
    }

    public function delete(User $user, Client $client): bool
    {
        return $this->canAccess($user, $client);
    }

    public function restore(User $user, Client $client): bool
    {
        return $this->canAccess($user, $client);
    }

    private function canAccess(User $user, Client $client): bool
    {
        if ($user->isAdmin() || $user->isHead()) {
            return true;
        }

        return $client->manager_id === $user->id;
    }
}
