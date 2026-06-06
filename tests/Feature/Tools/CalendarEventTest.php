<?php

declare(strict_types=1);

namespace Tests\Feature\Tools;

use App\Enums\UserRole;
use App\Models\CalendarEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_calendar_event(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);

        $response = $this->actingAs($user)->post(route('tools.calendar.store'), [
            'title' => 'Meeting',
            'starts_at' => '2026-06-10 09:00:00',
            'ends_at' => '2026-06-10 10:00:00',
            'description' => 'Team sync',
            'all_day' => false,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('calendar_events', [
            'user_id' => $user->id,
            'title' => 'Meeting',
        ]);
    }

    public function test_user_can_destroy_own_event(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);
        $event = CalendarEvent::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tools.calendar.destroy', $event));

        $response->assertRedirect();
        $this->assertDatabaseMissing('calendar_events', ['id' => $event->id]);
    }

    public function test_ends_at_must_be_after_starts_at(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);

        $response = $this->actingAs($user)->post(route('tools.calendar.store'), [
            'title' => 'Meeting',
            'starts_at' => '2026-06-10 10:00:00',
            'ends_at' => '2026-06-10 09:00:00',
        ]);

        $response->assertSessionHasErrors('ends_at');
    }
}
