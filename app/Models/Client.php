<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\HasTrackedChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Client extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes, HasTrackedChanges;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'avatar',
        'comment',
        'client_status_id',
        'manager_id',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    // Relations

    public function status(): BelongsTo
    {
        return $this->belongsTo(ClientStatus::class, 'client_status_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function files(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    // Scopes

    public function scopeMine(Builder $query): Builder
    {
        if (auth()->user()?->hasRole(UserRole::Manager->value)) {
            return $query->where('manager_id', auth()->id());
        }

        return $query;
    }

    public function scopeLoyal(Builder $query): Builder
    {
        return $query->whereHas('deals', null, '>', 1);
    }

    public function scopeWithStatus(Builder $query, string $slug): Builder
    {
        return $query->whereHas('status', fn (Builder $q) => $q->where('slug', $slug));
    }
}
