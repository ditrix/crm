<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'deleted_at',
        'description',
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
