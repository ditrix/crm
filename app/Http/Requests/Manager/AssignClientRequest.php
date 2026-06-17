<?php

declare(strict_types=1);

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class AssignClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && ($user->isAdmin() || $user->isHead());
    }

    public function rules(): array
    {
        return [
            'manager_id' => ['required', 'exists:users,id'],
        ];
    }
}
