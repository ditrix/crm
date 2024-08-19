<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
