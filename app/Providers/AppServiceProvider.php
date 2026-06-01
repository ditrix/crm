<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Client;
use App\Models\Deal;
use App\Models\User;
use App\Policies\ClientPolicy;
use App\Policies\DealPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Client::class => ClientPolicy::class,
        Deal::class => DealPolicy::class,
    ];

    public function register(): void {}

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('viewLogViewer', function (?User $user): bool {
            return $user?->isAdmin() ?? false;
        });
    }
}
