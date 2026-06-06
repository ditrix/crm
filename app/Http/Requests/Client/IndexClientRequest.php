<?php

declare(strict_types=1);

namespace App\Http\Requests\Client;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;

class IndexClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Client::class);
    }

    public function rules(): array
    {
        return [
            'archived' => ['nullable', 'boolean'],
            'status' => ['nullable', 'integer', 'exists:client_statuses,id'],
            'manager' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
