<?php

declare(strict_types=1);

namespace App\Http\Requests\Reminder;

use Illuminate\Foundation\Http\FormRequest;

class StoreReminderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:255'],
            'remind_at' => ['required', 'date'],
        ];
    }
}
