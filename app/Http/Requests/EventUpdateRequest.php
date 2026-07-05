<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'thumbnail'     => 'required|image|mimes:png,jpg,jpeg',
            'name'          => 'required|string|max:255',
            'description'   => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'date'          => 'required|date',
            'time'          => 'required|date_format:H:i:s',
            'is_active'     => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail'     => 'Banner',
            'name'          => 'Nama',
            'description'   => 'Deskripsi',
            'price'         => 'Harga',
            'date'          => 'Tanggal',
            'time'          => 'Jam',
            'is_active'     => 'active',
        ];
    }
}
