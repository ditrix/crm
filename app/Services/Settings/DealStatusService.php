<?php

declare(strict_types=1);

namespace App\Services\Settings;

use App\Models\DealStatus;
use App\Services\Cache\CacheInvalidator;
use App\Services\Cache\ReferenceDataCache;
use Illuminate\Database\Eloquent\Collection;

final class DealStatusService
{
    public function __construct(
        private readonly ReferenceDataCache $referenceDataCache,
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function listAll(): Collection
    {
        return $this->referenceDataCache->dealStatusesAll();
    }

    public function create(array $data): DealStatus
    {
        $status = DealStatus::create($data);

        $this->cacheInvalidator->forgetDealStatuses();

        return $status;
    }

    public function update(DealStatus $dealStatus, array $data): DealStatus
    {
        $dealStatus->update($data);

        $this->cacheInvalidator->forgetDealStatuses();
        $this->cacheInvalidator->forgetDealsByStatusId($dealStatus->id);

        return $dealStatus;
    }

    public function delete(DealStatus $dealStatus): void
    {
        $statusId = $dealStatus->id;

        $dealStatus->delete();

        $this->cacheInvalidator->forgetDealStatuses();
        $this->cacheInvalidator->forgetDealsByStatusId($statusId);
    }

    public function restore(int $id): DealStatus
    {
        $status = DealStatus::withTrashed()->findOrFail($id);
        $status->restore();

        $this->cacheInvalidator->forgetDealStatuses();

        return $status;
    }
}
