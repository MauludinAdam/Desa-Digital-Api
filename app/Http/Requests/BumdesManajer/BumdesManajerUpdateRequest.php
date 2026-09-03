<?php

namespace App\Http\Requests\BumdesManajer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesManajerUpdateRequest extends FormRequest
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
            'bumdes_id'         => 'nullable|string|max:200',
            'name'              => 'required|string|max:200',
            'position'           => 'required|string|max:150',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string|max:500',
            'photo'             => 'image|mimes:jpg,jpeg,png|max:2048',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date',
            // 'status'            => 'required|string|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'bumdes_id'         => 'Bumdes',
            'name'              => 'Nama',
            'position'          => 'Posisi',
            'phone'             => 'No.Telp',
            'address'           => 'Alamat',
            'photo'             => 'Foto',
            'start_date'        => 'Mulai',
            'end_date'          => 'Selesai',
            'status'            => 'Status',
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
            'photo.image'               => ':attribute harus berupa gambar',
            'photo.mimes'               => ':attribute harus berupa PNG JPG JPEG WEBP',
            'photo.max'                 => ':attribute maksimal 2MB',
            'start_date.required'       => ':attribute harus diisi',
            'start_date.date'           => ':attribute harus berupa tanggal bulan dan tahun',
            'end_date.required'         => ':attribute harus disiis',        
            'end_date.date'             => ':attribute harus berupa tanggal bulan dan tahun',
            // 'status.required'           => ':attribute harus diisi',
        ];
    }
}
