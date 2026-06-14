<?php

declare(strict_types=1);

namespace App\Services\Deal;

use App\Http\Requests\Deal\IndexDealRequest;
use App\Models\Client;
use App\Models\Deal;
use App\Models\DealStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class DealService
{
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
        return [
            'statuses' => DealStatus::ordered()->get(),
            'clients' => Client::mine()->get(['id', 'name']),
        ];
    }

    public function loadForShow(Deal $deal): Deal
    {
        return $deal->load(['client', 'status', 'updatedBy', 'createdBy', 'files']);
    }

    public function update(Deal $deal, array $data): void
    {
        $deal->update($data);
    }

    public function delete(Deal $deal): void
    {
        $deal->delete();
    }
}
