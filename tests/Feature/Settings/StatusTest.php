<?php

declare(strict_types=1);

namespace Tests\Feature\Settings;

use App\Enums\UserRole;
use App\Models\ClientStatus;
use App\Models\DealStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_client_status(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);

        $response = $this->actingAs($admin)->post(route('settings.client-statuses.store'), [
            'name' => 'New status',
            'slug' => 'new-status',
            'sort_order' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('client_statuses', ['slug' => 'new-status']);
    }

    public function test_admin_can_restore_client_status(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);
        $status = ClientStatus::factory()->create();
        $status->delete();

        $response = $this->actingAs($admin)->post(route('settings.client-statuses.restore', $status->id));

        $response->assertRedirect();
        $this->assertNull($status->fresh()->deleted_at);
    }

    public function test_admin_can_create_deal_status(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);

        $response = $this->actingAs($admin)->post(route('settings.deal-statuses.store'), [
            'name' => 'Won',
            'slug' => 'won',
            'sort_order' => 2,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('deal_statuses', ['slug' => 'won']);
    }

    public function test_manager_cannot_create_client_status(): void
    {
        $manager = $this->createUserWithRole(UserRole::Manager);

        $response = $this->actingAs($manager)->post(route('settings.client-statuses.store'), [
            'name' => 'Blocked',
            'slug' => 'blocked',
        ]);

        $response->assertForbidden();
    }

    public function test_head_can_update_deal_status(): void
    {
        $head = $this->createUserWithRole(UserRole::Head);
        $status = DealStatus::factory()->create(['name' => 'Old', 'slug' => 'old']);

        $response = $this->actingAs($head)->patch(route('settings.deal-statuses.update', $status), [
            'name' => 'Updated',
            'slug' => 'updated',
            'sort_order' => 5,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('deal_statuses', [
            'id' => $status->id,
            'name' => 'Updated',
        ]);
    }
}
