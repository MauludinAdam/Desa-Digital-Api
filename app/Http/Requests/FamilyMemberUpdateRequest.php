<?php

namespace App\Http\Requests;

use App\Models\FamilyMember;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FamilyMemberUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,' . FamilyMember::find($this->route('family_member'))->user_id,
            'password'      => 'nullable|string|min:8',
            'profile_picture'   => 'required|image|mimes:png,jpg,jpeg',
            'identity_number'   => 'required|string|max:16',
            'gender'            => 'required|string|in:male,female',
            'date_birth'        => 'required|date',
            'phone_number'      => 'required|string|max:12',
            'occupation'        => 'required|string',
            'marital_status'    => 'required|string|in:married,single',
            'relation'          => 'required|string|in:wife,child,husband',
        ];
    }

    public function attributes()
    {
        return [
            'name'              => 'Nama',
            'email'             => 'Email',
            'password'          => 'Kata Sandi',
            'profile_picture'   => 'Foto Profile',
            'identity_number'   => 'Nomor Identitas',
            'gender'            => 'Jenis Kelamin',
            'phone_number'      => 'Nomor Telpon',
            'occupation'        => 'Pekerjaan',
            'marital_status'    => 'Status Perkawinan',
            'relation'          => 'Hubungan',
        ];
    }
}
