<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contract_type_id',
        'contract_status_id',
        'code',
        'title',
        'comment',
        'summ',
        'is_active',
        'active_from',
        'active_to'
    ];
}
