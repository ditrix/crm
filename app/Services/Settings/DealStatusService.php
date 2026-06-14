<?php

declare(strict_types=1);

namespace App\Services\Settings;

use App\Models\DealStatus;
use Illuminate\Database\Eloquent\Collection;

final class DealStatusService
{
    public function listAll(): Collection
    {
        return DealStatus::withTrashed()->ordered()->get();
    }

    public function create(array $data): DealStatus
    {
        return DealStatus::create($data);
    }

    public function update(DealStatus $dealStatus, array $data): DealStatus
    {
        $dealStatus->update($data);

        return $dealStatus;
    }

    public function delete(DealStatus $dealStatus): void
    {
        $dealStatus->delete();
    }

    public function restore(int $id): DealStatus
    {
        $status = DealStatus::withTrashed()->findOrFail($id);
        $status->restore();

        return $status;
    }
}
