<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'user_id'       => 'nullable',
            'status'        => 'nullable',
            'name'          => 'nullable',
            'email'         => 'nullable',
            'phone'         => 'nullable',
            'address'       => 'nullable',
            'is_legal'      => 'nullable',
            'is_active'     => 'nullable',
            'code'          => 'nullable',
            'contact_name'  => 'nullable',
            'contact_email' => 'nullable',
            'contact_phone' => 'nullable',
            'deleted_at'    => 'nullable',
        ];
    }
}
