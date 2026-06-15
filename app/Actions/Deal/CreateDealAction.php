<?php

declare(strict_types=1);

namespace App\Actions\Deal;

use App\Models\Deal;
use App\Services\Cache\CacheInvalidator;

final class CreateDealAction
{
    public function __construct(
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function execute(array $data): Deal
    {
        $data['created_by'] = auth()->id();

        $deal = Deal::create($data);

        $this->cacheInvalidator->forgetDeal($deal->load('client'));

        return $deal;
    }
}
