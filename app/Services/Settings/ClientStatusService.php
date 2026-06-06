<?php

declare(strict_types=1);

namespace App\Services\Settings;

use App\Models\ClientStatus;
use Illuminate\Database\Eloquent\Collection;

final class ClientStatusService
{
    public function listAll(): Collection
    {
        return ClientStatus::withTrashed()->ordered()->get();
    }

    public function create(array $data): ClientStatus
    {
        return ClientStatus::create($data);
    }

    public function update(ClientStatus $clientStatus, array $data): ClientStatus
    {
        $clientStatus->update($data);

        return $clientStatus;
    }

    public function delete(ClientStatus $clientStatus): void
    {
        $clientStatus->delete();
    }

    public function restore(int $id): ClientStatus
    {
        $status = ClientStatus::withTrashed()->findOrFail($id);
        $status->restore();

        return $status;
    }
}
