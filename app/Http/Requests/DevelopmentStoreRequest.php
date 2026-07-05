<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DevelopmentStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'thumbnail'         => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'name'              => 'required|string|in:pembuatan jalan,perbaiki jalan,pembuatan jembatan',
            'description'       => 'required|string|max:255',
            'person_in_charge'  => 'required|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date',
            'amount'            => 'required|',
            'status'            =>  'required|string|in:on going,completed',
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail'         => 'Gambar',
            'name'              => 'Nama',
            'description'       => 'Deskripsi',
            'person_in_charge'  => 'Penanggung Jawab',
            'start_date'        => 'Tanggal Mulai',
            'end_date'          => 'Tanggal Berakhir',
            'amount'            => 'Jumlah Bantuan',
            'status'            => "Status",
        ];
    }
}
