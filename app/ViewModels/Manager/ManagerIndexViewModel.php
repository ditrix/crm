<?php

declare(strict_types=1);

namespace App\ViewModels\Manager;

use App\Services\Manager\ManagerService;

final class ManagerIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(ManagerService $service): self
    {
        return new self([
            'managers' => $service->paginateManagers(),
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
