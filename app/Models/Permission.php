<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
