<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $role
 * @property int $rw_own_customer
 * @property int $rw_own_deals
 * @property int $rw_own_reports
 * @property int $rw_customer
 * @property int $rw_deals
 * @property int $rw_reports
 * @property int $rw_options
 * @property int $rw_parameters
 * @property int $rw_users
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $role_name
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRwCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRwDeals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRwOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRwOwnCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRwOwnDeals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRwOwnReports($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRwParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRwReports($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRwUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends Model
{
    use HasFactory;

    const ROLE_ADMIN = 'admin';
    const ROLE_TOP_MANAGER = 'top_manager';
    const ROLE_MANAGER = 'manager';

    protected $fillable = [
        'role',
        'rw_own_customer',
        'rw_own_deals',
        'rw_own_reports',
        'rw_customer',
        'rw_deals',
        'rw_reports',
        'rw_options',
        'rw_parameters',
        'rw_users',
    ];

    protected $appends = ['role_name'];

    public function getRoleNameAttribute()
    {
        switch ($this->role) {

            case 'manager':

                return 'Manager';

            case 'top_manager':

                return 'Top Manager';

            case 'admin':

                return 'Admin';

            default:
                return 'Unknown Role';
        }
    }

    public function getRoleName()
    {
        switch ($this->role) {

            case self::ROLE_MANAGER:

                return 'Manager';

            case self::ROLE_TOP_MANAGER:

                return 'Top Manager';

            case self::ROLE_ADMIN:

                return 'Admin';

            default:
                return 'Unknown Role';
        }
    }
}
