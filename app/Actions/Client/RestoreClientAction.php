<?php

declare(strict_types=1);

namespace App\Actions\Client;

use App\Models\Client;
use App\Services\Cache\CacheInvalidator;

final class RestoreClientAction
{
    public function __construct(
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function execute(Client $client): void
    {
        $client->restore();

        $this->cacheInvalidator->forgetClient($client->fresh());
    }
}
