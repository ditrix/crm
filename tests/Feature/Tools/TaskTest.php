<?php

declare(strict_types=1);

namespace Tests\Feature\Tools;

use App\Enums\UserRole;
use App\Models\Task;
use App\Support\Cache\CacheKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_task(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);
        Cache::put(CacheKey::dashboardMetrics($user->id), ['tasksToday' => 0], 3600);

        $response = $this->actingAs($user)->post(route('tools.tasks.store'), [
            'title' => 'Test task',
            'due_date' => '2026-06-10',
            'description' => 'Description',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'Test task',
        ]);
        $this->assertFalse(Cache::has(CacheKey::dashboardMetrics($user->id)));
    }

    public function test_user_can_toggle_own_task(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);
        $task = Task::factory()->create(['user_id' => $user->id]);
        Cache::put(CacheKey::dashboardMetrics($user->id), ['tasksToday' => 1], 3600);

        $response = $this->actingAs($user)->post(route('tools.tasks.toggle', $task));

        $response->assertRedirect();
        $this->assertNotNull($task->fresh()->completed_at);
        $this->assertFalse(Cache::has(CacheKey::dashboardMetrics($user->id)));
    }

    public function test_user_can_destroy_own_task(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);
        $task = Task::factory()->create(['user_id' => $user->id]);
        Cache::put(CacheKey::dashboardMetrics($user->id), ['tasksToday' => 1], 3600);

        $response = $this->actingAs($user)->delete(route('tools.tasks.destroy', $task));

        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertFalse(Cache::has(CacheKey::dashboardMetrics($user->id)));
    }

    public function test_user_cannot_toggle_another_users_task(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);
        $other = $this->createUserWithRole(UserRole::Manager);
        $task = Task::factory()->create(['user_id' => $other->id]);

        $response = $this->actingAs($user)->post(route('tools.tasks.toggle', $task));

        $response->assertForbidden();
    }
}
