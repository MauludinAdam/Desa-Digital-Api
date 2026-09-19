<?php

namespace App\Http\Requests\users;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role_id'       => 'required|exists:roles,id',
            'name'          => 'required|string|max:250',
            'email'         => 'required|email|max:250',
            'password'      => 'required|string|max:250',
            'status'        => 'required|string|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'role_id'       => 'Role',
            'name'          => 'Nama',
            'email'         => 'Email',
            'password'      => 'password',
            'status'        => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required'      => ':attribute harus diisi',
            'name.required'         => ':attribute harus diisi',
            'email.required'        => ':attribute hasrus diisi',
            'email.email'           => ':attribute harus berupa email',
            'password.required'     => ':attribute harus diisi',
            'status.required'       => ':attribute harus diisi',   
        ];
    }
}
