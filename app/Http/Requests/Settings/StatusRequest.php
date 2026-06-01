<?php

declare(strict_types=1);

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:100'],
            'slug'       => ['required', 'string', 'max:50', 'regex:/^[a-z0-9_-]+$/'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
