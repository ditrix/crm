<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'role'              => 'nullable',
            'rw_own_customer'   => 'nullable',
            'rw_own_deals'      => 'nullable',
            'rw_own_reports'    => 'nullable',
            'rw_customer'       => 'nullable',
            'rw_deals'          => 'nullable',
            'rw_reports'        => 'nullable',
            'rw_options'        => 'nullable',
            'rw_parameters'     => 'nullable',
            'rw_users'          => 'nullable'
        ];
    }
}
