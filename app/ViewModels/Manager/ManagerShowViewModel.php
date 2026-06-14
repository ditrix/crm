<?php

declare(strict_types=1);

namespace App\ViewModels\Manager;

use App\Models\User;
use App\Services\Manager\ManagerService;

final class ManagerShowViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(ManagerService $service, User $user): self
    {
        return new self([
            'user' => $service->loadManagerWithClients($user),
            'managers' => $service->getManagerOptions(),
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
