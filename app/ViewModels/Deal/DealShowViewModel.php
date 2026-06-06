<?php

declare(strict_types=1);

namespace App\ViewModels\Deal;

use App\Models\Deal;

final class DealShowViewModel
{
    public function __construct(
        private readonly Deal $deal,
    ) {}

    public function toArray(): array
    {
        return ['deal' => $this->deal];
    }
}
