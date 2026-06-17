<?php

declare(strict_types=1);

namespace App\Http\Requests\Deal;

use App\Models\Deal;
use Illuminate\Foundation\Http\FormRequest;

class CreateDealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Deal::class);
    }

    public function rules(): array
    {
        return [
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
        ];
    }
}
