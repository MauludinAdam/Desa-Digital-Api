<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique|users',
            'password'  => 'required|string|min:8'
        ];
    }

    public function attributes()
    {
        return [
            'name'      => 'Name',
            'email'     => 'Email',
            'password'  => 'Kata Sandi',
        ];
    }

    public function messages()
    {
        return [
            'required'      => ':attribute harus diisi',
            'string'        => ':attribute harus berupa string',
            'max'           => ':attribute maksimal :max karakter',
            'min'           => ':attribute minimal :min karakter',
            'unique'        => ':attribute sudah ada',
            'email'         => ':attribute harus berupa email',
        ];
    }
}
