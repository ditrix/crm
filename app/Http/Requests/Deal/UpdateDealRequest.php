<?php

declare(strict_types=1);

namespace App\Http\Requests\Deal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('deal'));
    }

    public function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'max:255'],
            'client_id'      => ['required', 'exists:clients,id'],
            'deal_status_id' => ['nullable', 'exists:deal_statuses,id'],
            'amount'         => ['nullable', 'numeric', 'min:0'],
            'comment'        => ['nullable', 'string'],
        ];
    }
}
