<?php

namespace App\Http\Requests\BumdesManajer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesManajerStoreRequest extends FormRequest
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
            'bumdes_id'     => 'nullable|exists:bumdes,id',
            'name'          => 'required|string|max:200',
            'position'      => 'required|string|max:200',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string|max:500',
            'photo'         => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
            'start_date'    => 'required|date|max:200',
            'end_date'      => 'required|date|max:200',
        ];
    }

    public function attributes()
    {
        return [
            'bumdes_id'         => 'Bumdes',
            'name'              => 'Nama',
            'position'          => 'Posis',
            'phone'             => 'No.Telp',
            'address'           => 'Alamat',
            'photo'             => 'Foto',
            'start_date'        => 'Mulai',
            'end_date'          => 'Berakhir',
            'status'            => 'Status'
        ];
    }

    public function messages()
    {
        return [
            'bumdes_id.required'        => ':attribute harus diisi',
            'name.required'             => ':attribute harus diisi',
            'position.required'         => ':attribute harus diisi',
            'phone.required'            => ':attribute harus diisi',
            'address.required'          => ':attribute harus diisi',
            'photo.required'            => ':atribute harus diisi',
            'photo.max'                 => ':attribute maksimal 2MB',
            'photo.mimes'               => ':atribute harus JPG PNG JPEG WEBP',
            'photo.image'               => ':atribute harus berupa gambar',
            'start_date.required'       => ':attribute harus diisi',
            'start_date.date'           => ':attribute harus berupa tanggal',
            'end_year.required'         => ':attribute harus diisi',
            'send_year.date'           => ':attribute harus berupa tanggal',
        ];
    }
}
