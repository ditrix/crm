<?php

declare(strict_types=1);

namespace App\ViewModels\Note;

use App\Models\Note;

final class NoteIndexViewModel
{
    public function __construct(
        private readonly array $data,
    ) {}

    public static function from(Note $note): self
    {
        return new self([
            'note' => $note,
        ]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
