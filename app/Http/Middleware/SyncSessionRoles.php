<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\Cache\CacheInvalidator;
use App\Support\Cache\CacheKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SyncSessionRoles
{
    public function __construct(
        private readonly CacheInvalidator $cacheInvalidator,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user !== null) {
            $cachedVersion = Cache::get(CacheKey::userRolesVersion($user->id));

            if (! is_array(session('auth.roles')) || $cachedVersion !== session('auth.roles_version')) {
                $this->cacheInvalidator->applyUserRolesToSession($user);
            }
        }

        return $next($request);
    }
}
