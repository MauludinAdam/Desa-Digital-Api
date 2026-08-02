<?php

namespace App\Http\Requests\Citizen;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CitizenStoreRequest extends FormRequest
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
            'family_card_id'    => 'nullable|exists:family_card,id',
            'full_name'         => 'required|string|max:255',
            'nik'               => 'required|digits:16|unique:citizens,nik',
            'gender'            => 'required|in:male,female',
            'place_of_birth'    => 'required|string|max:255',
            'date_of_birth'     => 'required|date',
            'phone_number'      => 'required|string|max:12',
            'occupation_id'     => 'nullable|exists:occupations,id',
            'religion_id'       => 'nullable|exists:religions,id',
            'education_id'      => 'nullable|exists:educations,id',
            'marital_status'    => 'required|in:married,single,widower,widow',
            'blood_type'        => 'required|in:A,AB,B,O',
            'email'             => 'nullable|string|email|unique:citizens,email',
            'nationality'       => 'required|in:wni,wna',
            'status'            => 'required|in:active,moved,deceased'
        ];
    }

    public function attributes()
    {
        return [
            'family_card_id'        => 'Kartu Keluarga',
            'full_name'             => 'Nama Lengkap',
            'nik'                   => 'NIK',
            'gender'                => 'Jenis kelamin',
            'place_of_birth'        => 'Tempat Lahir',
            'date_of_birth'         => 'Tanggal Lahir',
            'phone_number'          => 'No.Telp',
            'occupation_id'         => 'Pekerjaan',
            'religion_id'           => 'Agama',
            'education_id'          => 'Pendidikan',
            'marital_status'        => 'Status Perkawinan',
            'blood_type'            => 'Golongan Darah',
            'email'                 => 'Email',
            'nationality'           => 'Kewarganegaraan',
            'status'                => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'family_card_id'            => 'Kartu Keluarga harus diisi',
            'full_name.required'        => 'Nama lengkap harus diisi',
            'nik.required'              => 'NIK harus diisi',
            'gender.required'           => 'Jenis kelamin harus diisi',
            'place_of_birth.required'   => 'Tempat lahir harus diisi',
            'date_of_birth.required'    => 'Tanggal lahir harus diisi',
            'phone_number.required'     => 'No.Telp harus diisi',
            'occupation_id.required'    => 'Pekerjaan harus diisi',
            'religion_id.required'      => 'Agama harus diisi',
            'education_id.required'     => 'Pendidikan harus diisi',
            'marital_status.required'   => 'Status perkawinan harus diisi',
            'blood_type.required'       => 'Golongan darah harus diisi',
            'email.required'            => 'Email harus diisi',
            'nationality.required'      => 'Kewarga negaraan harus diisi',
            'status.required'           => 'Status harus diisi',                                                 
        ];
    }
}
