<?php

declare(strict_types=1);

namespace App\ViewModels\Settings;

use App\Services\Settings\ClientStatusService;

final class ClientStatusIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(ClientStatusService $service): self
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
