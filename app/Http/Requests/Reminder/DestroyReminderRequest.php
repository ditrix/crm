<?php

declare(strict_types=1);

namespace App\Http\Requests\Reminder;

use App\Models\Reminder;
use Illuminate\Foundation\Http\FormRequest;

class DestroyReminderRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Reminder $reminder */
        $reminder = $this->route('reminder');

        return $reminder->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [];
    }
}
