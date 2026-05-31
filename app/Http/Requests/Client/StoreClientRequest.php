<?php

declare(strict_types=1);

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Client::class);
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['nullable', 'email', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:50'],
            'company'          => ['nullable', 'string', 'max:255'],
            'comment'          => ['nullable', 'string'],
            'client_status_id' => ['nullable', 'exists:client_statuses,id'],
            'manager_id'       => ['nullable', 'exists:users,id'],
        ];
    }
}
