<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Customer;
use App\Models\Contract\ContractType;

/**
 *
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $contract_type_id
 * @property int|null $contract_status_id
 * @property int|null $customer_id
 * @property string|null $code
 * @property string|null $title
 * @property string|null $comment
 * @property string $summ
 * @property int $is_active
 * @property string|null $active_from
 * @property string|null $active_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ContractType|null $contract_type
 * @property-read \App\Models\Customer|null $customer
 * @method static \Database\Factories\ContractFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereActiveFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereActiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereContractStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereContractTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereSumm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereUserId($value)
 * @mixin \Eloquent
 */
class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'contract_type_id',
        'contract_status_id',
        'code',
        'title',
        'comment',
        'summ',
        'is_active',
        'active_from',
        'active_to',
        'created_at',
        'updated_at'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function contract_type(): BelongsTo
    {
        return $this->belongsTo(ContractType::class);
    }
}
