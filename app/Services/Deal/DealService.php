<?php

declare(strict_types=1);

namespace App\Services\Deal;

use App\Http\Requests\Deal\IndexDealRequest;
use App\Models\Deal;
use App\Services\Cache\CacheInvalidator;
use App\Services\Cache\ReferenceDataCache;
use App\Support\Cache\CacheKey;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class DealService
{
    public function __construct(
        private readonly ReferenceDataCache $referenceDataCache,
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function paginateFiltered(IndexDealRequest $request): LengthAwarePaginator
    {
        $showArchived = $request->boolean('archived');

        return Deal::with(['client', 'status', 'updatedBy'])
            ->when(auth()->user()->isManager(), fn ($q) => $q->forManager(auth()->id()))
            ->when($showArchived, fn ($q) => $q->withTrashed())
            ->when(! $showArchived, fn ($q) => $q->withoutTrashed())
            ->when($request->filled('status'), fn ($q) => $q->where('deal_status_id', $request->input('status')))
            ->when($request->filled('client'), fn ($q) => $q->where('client_id', $request->input('client')))
            ->latest()
            ->paginate(50)
            ->withQueryString();
    }

    public function getFormOptions(): array
    {
        $user = auth()->user();

        return [
            'statuses' => $this->referenceDataCache->dealStatusesOrdered(),
            'clients' => $this->referenceDataCache->dealFormClients($user),
        ];
    }

    public function loadForShow(Deal $deal): Deal
    {
        return Cache::remember(
            CacheKey::dealShow($deal->id),
            CacheKey::ENTITY_TTL,
            fn () => $deal->load(['client', 'status', 'updatedBy', 'createdBy', 'files'])
        );
    }

    public function update(Deal $deal, array $data): void
    {
        $deal->update($data);

        $this->cacheInvalidator->forgetDeal($deal->fresh(['client']));
    }

    public function delete(Deal $deal): void
    {
        $deal->load('client');

        $deal->delete();

        $this->cacheInvalidator->forgetDeal($deal);
    }
}
