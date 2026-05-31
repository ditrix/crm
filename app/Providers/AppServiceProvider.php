<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Client;
use App\Models\Deal;
use App\Policies\ClientPolicy;
use App\Policies\DealPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class AppServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Client::class => ClientPolicy::class,
        Deal::class   => DealPolicy::class,
    ];

    public function register(): void {}

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
