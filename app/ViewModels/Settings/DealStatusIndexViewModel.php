<?php

declare(strict_types=1);

namespace App\ViewModels\Settings;

use App\Services\Settings\DealStatusService;

final class DealStatusIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(DealStatusService $service): self
    {
        return new self([
            'statuses' => $service->listAll(),
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
