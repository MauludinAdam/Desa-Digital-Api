<?php

namespace App\Http\Requests\users;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'token'     => 'required',
            'email'     => 'required|email',
            'password'  => 'required|min:8|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'token'                 => 'Token',
            'email'                 => 'Email',
            'password'              => 'Password',
            'password_confirmation' => 'Konfirmasi Password'
        ];
    }

    public function messages()
    {
        return [
            'email.required'        => ':attribute harus diisi',
            'email.email'           => ':attribute harus berupa email yang valid',
            'password.required'     => ':attribute harus diisi',
            'password.min'          => ':attribute minimal 8 karakter',
            'password.confirmed'    => ':attribute dan konfirmasi password harus sama',
        ];
    }
}
