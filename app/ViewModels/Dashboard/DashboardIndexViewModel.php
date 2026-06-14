<?php

declare(strict_types=1);

namespace App\ViewModels\Dashboard;

use App\Models\User;
use App\Services\Dashboard\DashboardService;

final class DashboardIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(DashboardService $service, User $user): self
    {
        return new self($service->getMetrics($user));
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
