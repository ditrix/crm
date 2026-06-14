<?php

declare(strict_types=1);

namespace App\ViewModels\Client;

use App\Http\Requests\Client\IndexClientRequest;
use App\Services\Client\ClientService;

final class ClientIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(ClientService $service, IndexClientRequest $request): self
    {
        $options = $service->getFormOptions();

        return new self([
            'clients' => $service->paginateFiltered($request),
            'statuses' => $options['statuses'],
            'managers' => $options['managers'],
            'showArchived' => $request->boolean('archived'),
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
