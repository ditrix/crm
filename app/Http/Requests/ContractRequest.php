<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'               => 'nullable|integer',
            'contract_type_id'      => 'nullable|integer',
            'contract_status_id'    => 'nullable|integer',
            'customer_id'           => 'nullable|integer',
            'code'                  => 'nullable|string',
            'title'                 => 'nullable|string',
            'comment'               => 'nullable|string',
            'summ'                  => 'nullable|numeric|min:100',
            'is_active'             => 'nullable|boolean',
            'active_from'           => 'nullable',
            'active_to'             => 'nullable',
        ];
    }
}
