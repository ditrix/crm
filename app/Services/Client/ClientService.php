<?php

declare(strict_types=1);

namespace App\Services\Client;

use App\Http\Requests\Client\IndexClientRequest;
use App\Models\Client;
use App\Services\Cache\CacheInvalidator;
use App\Services\Cache\ReferenceDataCache;
use App\Support\Cache\CacheKey;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class ClientService
{
    public function __construct(
        private readonly ReferenceDataCache $referenceDataCache,
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function paginateFiltered(IndexClientRequest $request): LengthAwarePaginator
    {
        $showArchived = $request->boolean('archived');

        return Client::with(['status', 'manager', 'updatedBy'])
            ->mine()
            ->when($showArchived, fn ($q) => $q->withTrashed())
            ->when(! $showArchived, fn ($q) => $q->withoutTrashed())
            ->when($request->filled('status'), fn ($q) => $q->where('client_status_id', $request->input('status')))
            ->when($request->filled('manager'), fn ($q) => $q->where('manager_id', $request->input('manager')))
            ->latest()
            ->paginate(50)
            ->withQueryString();
    }

    public function getFormOptions(): array
    {
        return [
            'statuses' => $this->referenceDataCache->clientStatusesOrdered(),
            'managers' => $this->referenceDataCache->activeManagers(),
        ];
    }

    public function loadForShow(Client $client): Client
    {
        return Cache::remember(
            CacheKey::clientShow($client->id),
            CacheKey::ENTITY_TTL,
            fn () => $client->load(['status', 'manager', 'deals.status', 'updatedBy', 'createdBy', 'files'])
        );
    }

    public function delete(Client $client): void
    {
        $client->delete();

        $this->cacheInvalidator->forgetClient($client);
    }
}
