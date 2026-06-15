<?php

declare(strict_types=1);

namespace App\Actions\Deal;

use App\Models\Deal;
use App\Services\Cache\CacheInvalidator;

final class RestoreDealAction
{
    public function __construct(
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function execute(Deal $deal): void
    {
        $deal->restore();

        $this->cacheInvalidator->forgetDeal($deal->fresh(['client']));
    }
}
