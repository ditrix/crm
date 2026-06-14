<?php

declare(strict_types=1);

namespace Tests\Feature\Tools;

use App\Enums\UserRole;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_creates_note_for_user(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);

        $response = $this->actingAs($user)->get(route('tools.note'));

        $response->assertOk();
        $this->assertDatabaseHas('notes', [
            'user_id' => $user->id,
            'content' => '',
        ]);
    }

    public function test_user_can_update_note_content(): void
    {
        $user = $this->createUserWithRole(UserRole::Manager);
        Note::factory()->create(['user_id' => $user->id, 'content' => '']);

        $response = $this->actingAs($user)->patchJson(route('tools.note.update'), [
            'content' => 'My note text',
        ]);

        $response->assertOk();
        $response->assertJson(['saved' => true]);
        $this->assertDatabaseHas('notes', [
            'user_id' => $user->id,
            'content' => 'My note text',
        ]);
    }
}
