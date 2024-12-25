<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $is_active
 * @property int $order_condition
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus whereOrderCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContractStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'order_condition'
    ];
}
