<?php

declare(strict_types=1);

namespace Tests\Feature\Tools;

use App\Enums\UserRole;
use App\Models\Reminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_reminder(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);

        $response = $this->actingAs($user)->post(route('tools.reminders.store'), [
            'message' => 'Call client',
            'remind_at' => '2026-06-10 10:00:00',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reminders', [
            'user_id' => $user->id,
            'message' => 'Call client',
        ]);
    }

    public function test_user_can_dismiss_own_reminder(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);
        $reminder = Reminder::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('tools.reminders.dismiss', $reminder));

        $response->assertRedirect();
        $this->assertNotNull($reminder->fresh()->notified_at);
    }

    public function test_pending_returns_json_for_user(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);
        Reminder::factory()->create([
            'user_id' => $user->id,
            'remind_at' => now()->subHour(),
            'notified_at' => null,
        ]);
        Reminder::factory()->dismissed()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('tools.reminders.pending'));

        $response->assertOk();
        $response->assertJsonCount(1);
    }
}
