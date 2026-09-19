<?php

namespace App\Http\Requests\Bumdes;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesUpdateRequest extends FormRequest
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
            'title'             => 'Title',
            'legal_number'      => 'Nomor Legalitas',
            'established_year'  => 'Tahun berdiri',
            'description'       => 'Deskripsi',
            'address'           => 'Alamat',
            'logo'              => 'Logo',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => ':atribute harus diisi',
            'title.required'            => ':atribute harus diisi',
            'legal_number.required'     => ':attribute harus diisi',
            'established_year.required' => ':attribute harus diisi',
            'description.required'      => ':attribute harus diisi',
            'address.required'          => ':attribue harus diisi',  
            'logo.image'                => ':attribute harus berupa gambar',
            'logo.mimes'                => ':attribute harus berupa JPG PNG JPEG WEBP',
            'logo.max'                  => ':attribute maksimal 2MB'       
        ];
    }
}
