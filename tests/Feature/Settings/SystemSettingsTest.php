<?php

declare(strict_types=1);

namespace Tests\Feature\Settings;

use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_system_settings(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);

        $response = $this->actingAs($admin)->get(route('settings.index'));

        $response->assertOk();
        $response->assertViewHas('settings');
    }

    public function test_admin_can_update_system_settings(): void
    {
        $admin = $this->createUserWithRole(UserRole::Admin);

        $response = $this->actingAs($admin)->patch(route('settings.update'), [
            'app_name' => 'Test CRM',
            'default_locale' => 'en',
        ]);

        $response->assertRedirect();
    }

    public function test_manager_cannot_update_system_settings(): void
    {
        $manager = $this->createUserWithRole(UserRole::Manager);

        $response = $this->actingAs($manager)->patch(route('settings.update'), [
            'app_name' => 'Hacked',
            'default_locale' => 'en',
        ]);

        $response->assertForbidden();
    }
}
