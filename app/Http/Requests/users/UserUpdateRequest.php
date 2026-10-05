<?php

namespace App\Http\Requests\users;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name'      => 'sometimes|string|max:250',
            'email'     => 'sometimes|email|max:255',

            'password_lama'  => 'nullable|required_with:password|password_lama',
            'password_baru'  => 'nullable|min:8|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'name'      => 'Nama',
            'email'     => 'Email',
            'password_lama' => 'Password lama',
            'password_baru' => 'Password baru',
            'password_confirmation' => 'Konfirmasi password',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => ':attribute harus diisi',
            'email.required'    => ':attribute harus diisi',
            'email.email'       => ':attribute harus berupa email yang valid',

            'password_lama.required_with'    => ':attribute harus diisi ketika ingin menggati password',
            'password_baru.min'                      => ':attribute minimal 8 karakter',
            'password_baru.confirmed'                => ':attribute dan konfimasi password harus sama',
        ];
    }
}
