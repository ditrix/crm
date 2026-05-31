<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case Admin   = 'admin';
    case Head    = 'head';
    case Manager = 'manager';

    public function label(): string
    {
        return match($this) {
            UserRole::Admin   => 'administrator',
            UserRole::Head    => 'head',
            UserRole::Manager => 'manager',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
