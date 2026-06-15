<?php

declare(strict_types=1);

namespace App\Services\Settings;

use App\Models\ClientStatus;
use App\Services\Cache\CacheInvalidator;
use App\Services\Cache\ReferenceDataCache;
use Illuminate\Database\Eloquent\Collection;

final class ClientStatusService
{
    public function __construct(
        private readonly ReferenceDataCache $referenceDataCache,
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function listAll(): Collection
    {
        return $this->referenceDataCache->clientStatusesAll();
    }

    public function create(array $data): ClientStatus
    {
        $status = ClientStatus::create($data);

        $this->cacheInvalidator->forgetClientStatuses();

        return $status;
    }

    public function update(ClientStatus $clientStatus, array $data): ClientStatus
    {
        $clientStatus->update($data);

        $this->cacheInvalidator->forgetClientStatuses();
        $this->cacheInvalidator->forgetClientsByStatusId($clientStatus->id);

        return $clientStatus;
    }

    public function delete(ClientStatus $clientStatus): void
    {
        $statusId = $clientStatus->id;

        $clientStatus->delete();

        $this->cacheInvalidator->forgetClientStatuses();
        $this->cacheInvalidator->forgetClientsByStatusId($statusId);
    }

    public function restore(int $id): ClientStatus
    {
        $status = ClientStatus::withTrashed()->findOrFail($id);
        $status->restore();

        $this->cacheInvalidator->forgetClientStatuses();

        return $status;
    }
}
