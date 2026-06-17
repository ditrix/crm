<?php

declare(strict_types=1);

namespace Tests\Feature\Cache;

use App\Enums\UserRole;
use App\Models\Client;
use App\Models\ClientStatus;
use App\Models\Deal;
use App\Models\DealStatus;
use App\Services\Cache\CacheInvalidator;
use App\Services\Client\ClientService;
use App\Services\Deal\DealService;
use App\Services\Settings\ClientStatusService;
use App\Support\Cache\CacheKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheInvalidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_show_cache_is_invalidated_after_update(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);
        $status = ClientStatus::factory()->create();
        $client = Client::factory()->create([
            'name' => 'Original Name',
            'client_status_id' => $status->id,
            'manager_id' => $admin->id,
            'created_by' => $admin->id,
        ]);

        $this->actingAs($admin);

        $service = app(ClientService::class);
        $cached = $service->loadForShow($client);
        $this->assertSame('Original Name', $cached->name);

        $client->update(['name' => 'Updated Name']);

        app(CacheInvalidator::class)->forgetClient($client->fresh());

        $fresh = $service->loadForShow($client->fresh());
        $this->assertSame('Updated Name', $fresh->name);
    }

    public function test_deal_update_invalidates_parent_client_show_cache(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);
        $clientStatus = ClientStatus::factory()->create();
        $dealStatus = DealStatus::factory()->create();
        $client = Client::factory()->create([
            'client_status_id' => $clientStatus->id,
            'manager_id' => $admin->id,
            'created_by' => $admin->id,
        ]);

        $deal = Deal::query()->create([
            'title' => 'Initial Deal',
            'client_id' => $client->id,
            'deal_status_id' => $dealStatus->id,
            'created_by' => $admin->id,
        ]);

        $this->actingAs($admin);

        $clientService = app(ClientService::class);
        $cachedClient = $clientService->loadForShow($client);
        $this->assertSame('Initial Deal', $cachedClient->deals->first()->title);

        $dealService = app(DealService::class);
        $dealService->update($deal, ['title' => 'Updated Deal']);

        $freshClient = $clientService->loadForShow($client->fresh());
        $this->assertSame('Updated Deal', $freshClient->deals->first()->title);
    }

    public function test_client_status_update_refreshes_form_options(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);
        $status = ClientStatus::factory()->create(['name' => 'Old Status Name']);

        $this->actingAs($admin);

        $optionsBefore = app(ClientService::class)->getFormOptions();
        $this->assertSame('Old Status Name', $optionsBefore['statuses']->firstWhere('id', $status->id)->name);

        app(ClientStatusService::class)->update($status, [
            'name' => 'New Status Name',
            'slug' => $status->slug,
            'sort_order' => $status->sort_order,
        ]);

        $optionsAfter = app(ClientService::class)->getFormOptions();
        $this->assertSame('New Status Name', $optionsAfter['statuses']->firstWhere('id', $status->id)->name);
    }

    public function test_login_stores_roles_in_session(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);

        $response = $this->post(route('login.post'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertSame([UserRole::Admin->value], session('auth.roles'));
        $this->assertSame(
            Cache::get(CacheKey::userRolesVersion($admin->id)),
            session('auth.roles_version')
        );
    }

    public function test_role_change_applies_on_next_request_without_relogin(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);
        $manager = $this->createUserWithRole(UserRole::Manager);

        $this->actingAs($admin);
        $manager->syncRoles([UserRole::Head->value]);
        app(CacheInvalidator::class)->invalidateUserRoles($manager->fresh());

        $this->actingAs($manager);
        session([
            'auth.roles' => [UserRole::Manager->value],
            'auth.roles_version' => null,
        ]);

        $this->get(route('dashboard'));

        $this->assertSame([UserRole::Head->value], session('auth.roles'));
        $this->assertTrue(auth()->user()->isHead());
    }
}
