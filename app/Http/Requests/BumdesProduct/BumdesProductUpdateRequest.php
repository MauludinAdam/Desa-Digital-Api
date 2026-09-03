<?php

namespace App\Http\Requests\BumdesProduct;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesProductUpdateRequest extends FormRequest
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
            'bumdes_unit_id'        => 'required|string|max:200',
            'name'                  => 'required|string|max:200',
            'price'                 => 'required|string|max:150',
            'photo'                 => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'type'                  => 'required|string|max:200',
            'status'                => 'required|string|max:200',
        ];
    }

    public function attributes()
    {
        return [
            'bumdes_unit_id'    => 'Unit Usaha',
            'name'              => 'Nama',
            'price'             => 'Harga',
            'photo'             => 'Gambar',
            'type'              => 'Type',
            'status'            => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'bumdes_unit_id.required' => ':attribute harus diisi',
            'name.required'           => ':attribute harus diisi',
            'price.required'          => ':attribute harus diisi',
            'photo.required'          => ':attribute harus diisi',
            'photo.image'             => ':attribute harus berupa gambar',
            'photo.mimes'             => ':attribute harus berupa jpg png jpeg webp',
            'photo.max'               => ':attribute maksimal 2MB',
            'type.required'           => ':attribute harus diisi',
            'status.required'         => ':attribute harus diisi',
        ];
    }
}
