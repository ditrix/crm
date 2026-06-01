<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED = ['en', 'ua', 'ru'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale', 'en'));

        if (in_array($locale, self::SUPPORTED, true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
