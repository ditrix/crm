<?php

declare(strict_types=1);

namespace Tests\Unit\Cache;

use App\Enums\UserRole;
use App\Models\Client;
use App\Models\Deal;
use App\Services\Cache\CacheInvalidator;
use App\Support\Cache\CacheKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheInvalidatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_forget_client_forgets_show_dashboard_and_form_options_keys(): void
    {
        Cache::spy();

        $client = new Client;
        $client->id = 10;
        $client->manager_id = 5;

        app(CacheInvalidator::class)->forgetClient($client);

        Cache::shouldHaveReceived('forget')->with(CacheKey::clientShow(10))->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::dashboardMetrics(5))->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::dealFormClients(5))->once();
    }

    public function test_forget_client_forgets_previous_manager_scoped_keys(): void
    {
        Cache::spy();

        $client = new Client;
        $client->id = 10;
        $client->manager_id = 7;

        app(CacheInvalidator::class)->forgetClient($client, 3);

        Cache::shouldHaveReceived('forget')->with(CacheKey::dashboardMetrics(7))->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::dealFormClients(7))->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::dashboardMetrics(3))->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::dealFormClients(3))->once();
    }

    public function test_forget_deal_forgets_deal_client_show_and_manager_dashboard(): void
    {
        Cache::spy();

        $deal = new Deal;
        $deal->id = 20;
        $deal->client_id = 10;
        $deal->setRelation('client', tap(new Client, function (Client $client): void {
            $client->id = 10;
            $client->manager_id = 4;
        }));

        app(CacheInvalidator::class)->forgetDeal($deal);

        Cache::shouldHaveReceived('forget')->with(CacheKey::dealShow(20))->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::clientShow(10))->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::dashboardMetrics(4))->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::dealFormClients(4))->once();
    }

    public function test_forget_client_statuses_forgets_reference_keys(): void
    {
        Cache::spy();

        app(CacheInvalidator::class)->forgetClientStatuses();

        Cache::shouldHaveReceived('forget')->with(CacheKey::clientStatusesOrdered())->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::clientStatusesAll())->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::clientStatusSlugMap())->once();
    }

    public function test_forget_deal_statuses_forgets_reference_keys(): void
    {
        Cache::spy();

        app(CacheInvalidator::class)->forgetDealStatuses();

        Cache::shouldHaveReceived('forget')->with(CacheKey::dealStatusesOrdered())->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::dealStatusesAll())->once();
        Cache::shouldHaveReceived('forget')->with(CacheKey::dealStatusSlugMap())->once();
    }

    public function test_forget_managers_forgets_active_managers_key(): void
    {
        Cache::spy();

        app(CacheInvalidator::class)->forgetManagers();

        Cache::shouldHaveReceived('forget')->with(CacheKey::activeManagers())->once();
    }

    public function test_invalidate_user_roles_bumps_version_in_cache(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);

        app(CacheInvalidator::class)->invalidateUserRoles($user);

        $this->assertNotNull(Cache::get(CacheKey::userRolesVersion($user->id)));
    }

    public function test_invalidate_user_roles_updates_current_user_session(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);
        session(['auth.roles' => ['stale-role']]);

        $this->actingAs($user);
        $user->syncRoles([UserRole::Head->value]);

        app(CacheInvalidator::class)->invalidateUserRoles($user->fresh());

        $this->assertSame([UserRole::Head->value], session('auth.roles'));
        $this->assertSame(
            Cache::get(CacheKey::userRolesVersion($user->id)),
            session('auth.roles_version')
        );
    }
}
