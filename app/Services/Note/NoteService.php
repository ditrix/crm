<?php

declare(strict_types=1);

namespace App\Services\Note;

use App\Models\Note;
use App\Models\User;

final class NoteService
{
    public function getOrCreateForUser(User $user): Note
    {
        return Note::firstOrCreate(
            ['user_id' => $user->id],
            ['content' => ''],
        );
    }

    public function updateForUser(User $user, ?string $content): Note
    {
        return Note::updateOrCreate(
            ['user_id' => $user->id],
            ['content' => $content ?? ''],
        );
    }
}
