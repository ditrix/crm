<?php

declare(strict_types=1);

namespace App\Services\Client;

use App\Http\Requests\Client\IndexClientRequest;
use App\Models\Client;
use App\Models\ClientStatus;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ClientService
{
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
            'statuses' => ClientStatus::ordered()->get(),
            'managers' => User::active()->role('manager')->get(),
        ];
    }

    public function loadForShow(Client $client): Client
    {
        return $client->load(['status', 'manager', 'deals.status', 'updatedBy', 'createdBy', 'files']);
    }

    public function delete(Client $client): void
    {
        $client->delete();
    }
}
