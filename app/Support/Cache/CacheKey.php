<?php

declare(strict_types=1);

namespace App\Support\Cache;

final class CacheKey
{
    public const ENTITY_TTL = 3600;

    public static function clientStatusesOrdered(): string
    {
        return 'reference:client-statuses:ordered';
    }

    public static function clientStatusesAll(): string
    {
        return 'reference:client-statuses:all';
    }

    public static function dealStatusesOrdered(): string
    {
        return 'reference:deal-statuses:ordered';
    }

    public static function dealStatusesAll(): string
    {
        return 'reference:deal-statuses:all';
    }

    public static function activeManagers(): string
    {
        return 'reference:managers:active';
    }

    public static function clientStatusSlugMap(): string
    {
        return 'reference:client-statuses:slug-map';
    }

    public static function dealStatusSlugMap(): string
    {
        return 'reference:deal-statuses:slug-map';
    }

    public static function clientShow(int $clientId): string
    {
        return "client:{$clientId}:show";
    }

    public static function dealShow(int $dealId): string
    {
        return "deal:{$dealId}:show";
    }

    public static function dashboardMetrics(int $userId): string
    {
        return "dashboard:user:{$userId}:metrics";
    }

    public static function dealFormClients(int $userId): string
    {
        return "form-options:deals:clients:user:{$userId}";
    }

    public static function userRolesVersion(int $userId): string
    {
        return "user:{$userId}:roles:version";
    }
}
