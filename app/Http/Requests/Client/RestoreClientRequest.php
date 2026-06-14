<?php

declare(strict_types=1);

namespace App\Http\Requests\Client;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;

class RestoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        $client = Client::withTrashed()->find($this->route('id'));

        return $client !== null && $this->user()->can('restore', $client);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer'],
        ];
    }
}
