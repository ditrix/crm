<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
