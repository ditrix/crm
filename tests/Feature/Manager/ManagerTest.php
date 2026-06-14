<?php

declare(strict_types=1);

namespace Tests\Feature\Manager;

use App\Enums\UserRole;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_managers_index(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);
        $this->createUserWithRole(UserRole::Manager);

        $response = $this->actingAs($admin)->get(route('managers.index'));

        $response->assertOk();
        $response->assertViewHas('managers');
    }

    public function test_admin_can_view_manager_show(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);
        $manager = $this->createUserWithRole(UserRole::Manager);

        $response = $this->actingAs($admin)->get(route('managers.show', $manager));

        $response->assertOk();
        $response->assertViewHas('user');
    }

    public function test_admin_can_toggle_manager_active_state(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);
        $manager = $this->createUserWithRole(UserRole::Manager, ['is_active' => true]);

        $response = $this->actingAs($admin)->post(route('managers.toggle', $manager));

        $response->assertRedirect();
        $this->assertFalse($manager->fresh()->is_active);
    }

    public function test_admin_can_assign_client_to_manager(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);
        $manager = $this->createUserWithRole(UserRole::Manager);
        $client = Client::factory()->create(['manager_id' => null]);

        $response = $this->actingAs($admin)->post(route('managers.assign-client', $client), [
            'manager_id' => $manager->id,
        ]);

        $response->assertRedirect();
        $this->assertEquals($manager->id, $client->fresh()->manager_id);
    }

    public function test_manager_cannot_access_managers_index(): void
    {
        $manager = $this->createUserWithRole(UserRole::Manager);

        $response = $this->actingAs($manager)->get(route('managers.index'));

        $response->assertForbidden();
    }
}
