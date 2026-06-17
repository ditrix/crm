<?php

declare(strict_types=1);

namespace App\Http\Requests\Deal;

use App\Models\Deal;
use Illuminate\Foundation\Http\FormRequest;

class IndexDealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Deal::class);
    }

    public function rules(): array
    {
        return [
            'archived' => ['nullable', 'boolean'],
            'status' => ['nullable', 'integer', 'exists:deal_statuses,id'],
            'client' => ['nullable', 'integer', 'exists:clients,id'],
        ];
    }
}
