<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class ClientStatus extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'sort_order'];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function scopeBySlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
