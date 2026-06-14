<?php

declare(strict_types=1);

namespace App\Actions\Deal;

use App\Models\Deal;

final class CreateDealAction
{
    public function execute(array $data): Deal
    {
        $data['created_by'] = auth()->id();

        return Deal::create($data);
    }
}
