<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Models\Client;
use App\Models\ClientStatus;
use App\Models\DealStatus;
use App\Models\User;
use App\Support\Cache\CacheKey;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final class ReferenceDataCache
{
    public function clientStatusesOrdered(): Collection
    {
        return Cache::rememberForever(
            CacheKey::clientStatusesOrdered(),
            fn () => ClientStatus::ordered()->get()
        );
    }

    public function clientStatusesAll(): Collection
    {
        return Cache::rememberForever(
            CacheKey::clientStatusesAll(),
            fn () => ClientStatus::withTrashed()->ordered()->get()
        );
    }

    public function dealStatusesOrdered(): Collection
    {
        return Cache::rememberForever(
            CacheKey::dealStatusesOrdered(),
            fn () => DealStatus::ordered()->get()
        );
    }

    public function dealStatusesAll(): Collection
    {
        return Cache::rememberForever(
            CacheKey::dealStatusesAll(),
            fn () => DealStatus::withTrashed()->ordered()->get()
        );
    }

    public function activeManagers(): Collection
    {
        return Cache::rememberForever(
            CacheKey::activeManagers(),
            fn () => User::active()->role('manager')->get()
        );
    }

    /**
     * @return array<string, int|null>
     */
    public function clientStatusSlugMap(): array
    {
        return Cache::rememberForever(
            CacheKey::clientStatusSlugMap(),
            fn () => ClientStatus::query()->pluck('id', 'slug')->all()
        );
    }

    /**
     * @return array<string, int|null>
     */
    public function dealStatusSlugMap(): array
    {
        return Cache::rememberForever(
            CacheKey::dealStatusSlugMap(),
            fn () => DealStatus::query()->pluck('id', 'slug')->all()
        );
    }

    public function dealFormClients(User $user): Collection
    {
        return Cache::remember(
            CacheKey::dealFormClients($user->id),
            CacheKey::ENTITY_TTL,
            fn () => $this->resolveDealFormClients($user)
        );
    }

    private function resolveDealFormClients(User $user): Collection
    {
        $query = Client::query();

        if ($user->isManager()) {
            $query->where('manager_id', $user->id);
        }

        return $query->get(['id', 'name']);
    }
}
