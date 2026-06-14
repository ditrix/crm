<?php

declare(strict_types=1);

namespace App\Actions\Client;

use App\Models\Client;

final class RestoreClientAction
{
    public function execute(Client $client): void
    {
        $client->restore();
    }
}
