<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarEvent extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'starts_at',
        'ends_at',
        'all_day',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at'   => 'datetime',
            'all_day'   => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
