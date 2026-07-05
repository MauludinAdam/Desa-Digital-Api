<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HeadOfFamilyStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'email'             => 'required|max:255|email|unique:users',
            'password'          => 'required|string|min:8',
            'profile_picture'   => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'identity_number'   => 'required|string|max:16',
            'gender'            => 'required|string|in:male,female',
            'date_birth'        => 'required|date',
            'phone_number'      => 'required|string',
            'occupation'        => 'required|string',
            'marital_status'    => 'required|string|in:married,single',
        ];
    }

    public function attributes()
    {
        return [
            'name'      => 'Nama',
            'email'      => 'Email',
            'password'      => 'Kata Sandi',
            'profile_picture'      => 'Foto Profil',
            'identity_number'       => 'Nomor Identitas (NIK)',
            'gender'                => 'Jenis Kelamin',
            'phone_number'          => 'Nomor Telpon',
            'occupation'            => 'Pekerjaan',
            'marital_status'        => 'status Perkawinan',
        ];
    }

}
