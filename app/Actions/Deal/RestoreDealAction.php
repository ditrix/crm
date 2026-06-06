<?php

declare(strict_types=1);

namespace App\Actions\Deal;

use App\Models\Deal;

final class RestoreDealAction
{
    public function execute(Deal $deal): void
    {
        $deal->restore();
    }
}
