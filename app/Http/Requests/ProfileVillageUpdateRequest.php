<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileVillageUpdateRequest extends FormRequest
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
            'name'              => 'required|string|max:250',
            'thumbnail'         => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'district'          => 'required|string|max:200',
            'regency'           => 'required|string|max:200',
            'about'             => 'nullable|string|max:500',
            'headman'           => 'required|string|max:200',
            'people'            => 'required|string|max:200',
            'total_area'        => 'required|string|max:200',
        ];
    }

    public function attributes()
    {
        return [
            'name'                  => 'Nama ',
            'thumbnail'              => 'Foto profile',
            'district'              => 'Kecamatan',
            'regency'               => 'Kabupaten',
            'about'                 => 'Tentang',
            'headman'               => 'Kepala Desa',
            'people'                => 'Masyarakat',
            'total_area'            => 'Total Wilayah',       
        ];
    }

    public function messages()
    {
        return [
            'name.required'                  => ':attribute harus diisi',
            'thumbnail.image'                => ':attribute harus berupa gambar',
            'thumbnail.mimes'                 => ':attribute harus berupa PNG,JPG,JPEG',
            'thumbnail.max'                   => ':attribute maksimal 2MB',
            'district.required'              => ':attribute harus diisi',
            'regency.required'               => ':attribute harus diisi',
            'headman.required'               => ':attribute harus diisi',
            'people.required'                => ':attribute harus diisi',
            'total_area.required'            => ':attribute harus diisi',
        ];
    }
}
