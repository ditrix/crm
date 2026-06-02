<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Deal;
use App\Models\User;

class DealPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active;
    }

    public function view(User $user, Deal $deal): bool
    {
        return $this->canAccess($user, $deal);
    }

    public function create(User $user): bool
    {
        return $user->is_active;
    }

    public function update(User $user, Deal $deal): bool
    {
        return $this->canAccess($user, $deal);
    }

    public function delete(User $user, Deal $deal): bool
    {
        return $this->canAccess($user, $deal);
    }

    public function restore(User $user, Deal $deal): bool
    {
        return $this->canAccess($user, $deal);
    }

    private function canAccess(User $user, Deal $deal): bool
    {
        if ($user->isAdmin() || $user->isHead()) {
            return true;
        }

        return $deal->client?->manager_id === $user->id;
    }
}
