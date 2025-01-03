<?php

namespace App\Models;

use App\Models\Contract\Contract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $status
 * @property string $name
 * @property string $email
 * @property string|null $address
 * @property string|null $phone
 * @property int $is_legal
 * @property int $is_active
 * @property string|null $code
 * @property string|null $contact_name
 * @property string|null $contact_email
 * @property string|null $contact_phone
 * @property string|null $description
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contract> $contracts
 * @property-read int|null $contracts_count
 * @property-read mixed $status_name
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereIsLegal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserId($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory;

    const STATUS_POTENCIAL = 'potencial';
    const STATUS_CURRENT = 'current';
    const STATUS_FORMER = 'former';

    protected $appends = ['status_name'];

    protected  $fillable = [
        'user_id',
        'status',
        'name',
        'email',
        'phone',
        'address',
        'is_legal',
        'is_active',
        'code',
        'contact_name',
        'contact_email',
        'contact_phone',
        'description',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function getStatusNameAttribute()
    {
        switch ($this->status) {

            case self::STATUS_POTENCIAL:

                return 'potencial';

            case self::STATUS_CURRENT:

                return 'current';

            case self::STATUS_FORMER:

                return 'former';

            default:
                return 'unknown';
        }
    }

    public function user(): HasOne
    {
        //return $this->hasOne(User::class);
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

}
