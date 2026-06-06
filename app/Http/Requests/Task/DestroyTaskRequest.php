<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class DestroyTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Task $task */
        $task = $this->route('task');

        return $task->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [];
    }
}
