<?php

namespace App\Http\Requests\BumdesUnit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesUnitUpdateRequest extends FormRequest
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
            'name'              => 'required|string|max:200',
            'business_type'     => 'required|string|max:200',
            'description'       => 'required|string|max:500',
            'established_year'  => 'required|date',
            'status'            => 'required|string|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'name'              => 'Nama Bidang Usaha',
            'business_type'     => 'Type Usaha',
            'description'       => 'Deskripsi',
            'established_year'  => 'Tahun Berdiri',
            'status'            => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'name'                   => ':attribute harus diisi',
            'business_type'          => ':attribute harus diisi',
            'description'            => ':attribute harus diisi',
            'established_year'       => ':attribute harus diisi',
            'established_year.date'  => ':attribute harus berupa tangga, bulan dan tahun',
            'status'                 => ':attribute harus diisi',
        ];
    }
}
