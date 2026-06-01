<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasTrackedChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Deal extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes, HasTrackedChanges;

    protected $fillable = [
        'title',
        'comment',
        'amount',
        'client_id',
        'deal_status_id',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'amount'     => 'decimal:2',
            'deleted_at' => 'datetime',
        ];
    }

    // Relations

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(DealStatus::class, 'deal_status_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    // Scopes

    public function scopeWithStatus(Builder $query, string $slug): Builder
    {
        return $query->whereHas('status', fn (Builder $q) => $q->where('slug', $slug));
    }

    public function scopeForManager(Builder $query, int $managerId): Builder
    {
        return $query->whereHas('client', fn (Builder $q) => $q->where('manager_id', $managerId));
    }
}
