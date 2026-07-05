<?php

namespace App\Http\Requests;

use App\Models\HeadOfFamily;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HeadOfFamilyUpdateRequest extends FormRequest
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
            'email'             => 'nullable|string|email|max:255|unique:users,email,' . HeadOfFamily::find($this->route('head_of_family'))->user_id,
            'password'          => 'nullable|string|min:8',
            'profile_picture'   => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'identity_number'   => 'required|string|max:16',
            'gender'            => 'required|string|in:male,female',
            'date_birth'        => 'required|date',
            'phone_number'      => 'required|string|max:12',
            'occupation'        => 'required|string',
            'marital_status'    => 'required|string|in:married,single',
        ];
    }

    public function attributes()
    {
        return [
            'name'              => 'Nama',
            'email'             => 'Email',
            'password'          => 'Kata Sandi',
            'profile_picture'   => 'Foto Profile',
            'identity_number'   => 'Nomor Identitas(NIK)',
            'gender'            => 'Jenis Kelamin',
            'phone_number'      => 'Nomor Telpon',
            'occupation'        => 'Pekerjaan',
            'marital_status'    => 'Status Perkawinan',
        ];
    }
}
