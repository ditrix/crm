<?php

declare(strict_types=1);

namespace App\ViewModels\Client;

use App\Models\Client;
use App\Services\Client\ClientService;

final class ClientFormViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function forCreate(ClientService $service): self
    {
        $options = $service->getFormOptions();

        return new self([
            'statuses' => $options['statuses'],
            'managers' => $options['managers'],
        ]);
    }

    public static function forEdit(ClientService $service, Client $client): self
    {
        $options = $service->getFormOptions();

        return new self([
            'client' => $client,
            'statuses' => $options['statuses'],
            'managers' => $options['managers'],
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
