<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string|null $description
 * @property int $is_active
 * @property int $order_condition
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereOrderCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContractType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'is_active',
        'order_condition',
        'description',
    ];
}
