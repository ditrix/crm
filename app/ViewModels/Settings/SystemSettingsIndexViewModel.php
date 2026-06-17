<?php

declare(strict_types=1);

namespace App\ViewModels\Settings;

use App\Services\Settings\SystemSettingsService;

final class SystemSettingsIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(SystemSettingsService $service): self
    {
        return new self([
            'settings' => $service->getSettings(),
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
