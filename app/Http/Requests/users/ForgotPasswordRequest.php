<?php

namespace App\Http\Requests\users;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'email'     => 'required|email',
        ];
    }

    public function attributes()
    {
        return [
            'email'     => 'Email',
        ];
    }

    public function messages()
    {
        return [
            'email.required'    => ':attribute harus diisi',
            'email.email'       => ':attribute harus berupa email yang valid',
        ];
    }
}
