<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FamilyMemberStoreRequest extends FormRequest
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
            'email'             => 'required|string|max:255|email|unique:users',
            'password'          => 'required|string|min:8',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'profile_picture'   => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'identity_number'   => 'required|string|max:16',
            'gender'            => 'required|string|in:male,female',
            'date_birth'        => 'required|date',
            'phone_number'      => 'required|string|max:12',
            'occupation'        => 'required|string',
            'marital_status'    => 'required|string|in:married,single,widower,widowe',
            'relation'          => 'required|string|in:wife,child,husband',
        ];
    }

    public function attributes()
    {
        return [
            'name'      => 'Nama',
            'email'      => 'Email',
            'password'      => 'Kata Sandi',
            'head_of_family_id' => 'Kepala Keluarga',
            'profile_picture'   => 'Foto Profil',
            'identity_number'   => 'Nomor Identitas (NIK)',
            'gender'            => 'Jenis Kelamin',
            'phone_number'      => 'Nomor Telpon',
            'occupation'        => 'Pekerjaan',
            'marital_status'    => 'Status Perkawinan',
            'relation'          => 'Hubungan',
        ];
    }
}
