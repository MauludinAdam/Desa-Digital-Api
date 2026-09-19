<?php

namespace App\Http\Requests\Bumdes;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesStoreRequest extends FormRequest
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
            'name'              => 'required|string|max:255',
            'title'              => 'required|string|max:255',
            'legal_number'      => 'required|string|max:255',
            'established_year'  => 'required|string|max:255',
            'description'       => 'required|string|max:500',
            'address'           => 'required|string|max:500',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'name'              => 'Nama',
            'legal_number'      => 'Nomor Legalitas',
            'established_year'  => 'Tahun Berdiri',
            'address'           => 'Alamat',
            'description'       => 'Deskripsi',
            'logo'              => 'logo',
        ];
    }

    public function messages()
    {
        return [
            'name.required'              => ':attribute harus diisi',
            'legal_number.required'      => ':attribute harus diisi',
            'established_year.required'  => ':attribute harus diisi',
            'address.required'           => ':attribute harus diisi',
            'descripton.required'        => ':attribute harus diisi',
            'logo.required'              => ':attribute harus diisi',
            'logo.image'                 => ':attribue harus berupa gambar',
            'logo.mimes'                 => ':attribue harus berupa JPG PNG JPEG WEBP',
        ];
    }
}
