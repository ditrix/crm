<?php

declare(strict_types=1);

namespace App\ViewModels\Client;

use App\Models\Client;

final class ClientShowViewModel
{
    public function __construct(
        private readonly Client $client,
    ) {}

    public function toArray(): array
    {
        return ['client' => $this->client];
    }
}
