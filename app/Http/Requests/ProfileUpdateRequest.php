<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'thumbnail'         => 'nullable|image',
            'name'              => 'required|string',
            'about'             => 'required|string',
            'headman'           => 'required|string',
            'people'            => 'required|integer',
            'agricultural_area' => 'required',
            'total_area'        => 'required',
            'images'            => 'nullable|array',
            'image.*'           => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail'         => 'Thumbnail',
            'name'              => 'Nama',
            'about'             => 'Deskripsi',
            'headman'           => 'Kepala Desa',
            'people'            => 'Jumlah Penduduk',
            'agricultural_area' => 'Luas Pertanian',
            'total_area'        => 'Total Wilayah',
            'images'            => 'Gambar',
        ];
    }
}
