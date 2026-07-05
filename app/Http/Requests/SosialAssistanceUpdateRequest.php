<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SosialAssistanceUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'thumbnail'         => 'nullable|image|mimes:png,jpg,jpeg',
            'name'              => 'required|string|max:255',
            'category'          => 'required|string|max:255',
            'amount'            => 'required|string|max:255',
            'provider'          => 'required|string|max:255',
            'description'       => 'required|string|max:255',
            'is_available'      => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail'     => 'Banner',
            'name'          => 'Nama',
            'category'      => 'Kategori',
            'amount'        => 'Jumlah Bantuan',
            'provider'      => 'Penyedia',
            'description'   => 'Deskripsi',
            'is_available'  => 'Ketersdiaan',
        ];
    }
}
