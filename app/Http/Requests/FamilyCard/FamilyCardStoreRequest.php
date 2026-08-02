<?php

namespace App\Http\Requests\FamilyCard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FamilyCardStoreRequest extends FormRequest
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
            'family_card_number'        => 'required|string|max:16',
            'head_of_family_id'         => 'nullable|string|max:255',
            'address'                   => 'required|string|max:500',
            'rt'                        => 'required|string|max:100',
            'rw'                        => 'required|string|max:100',
            'hamlet'                    => 'required|string|max:255',
            'village'                   => 'required|string|max:255',
            'district'                  => 'required|string|max:255',
            'regency'                   => 'required|string|max:255',
            'province'                  => 'required|string|max:255',
            'postal_code'               => 'required|string|max:255',           
        ];
    }

    public function attributes()
    {
        return [
            'family_card_number'        => 'Nomor Kartu Keluarga',
            'head_of_family_id'         => 'Kepala Keluarga',
            'address'                   => 'Alamat',
            'rt'                        => 'RT',
            'rw'                        => 'RW',
            'hamlet'                    => 'Dusun',
            'village'                   => 'Desa',
            'distinct'                  => 'Kecamatan',
            'regency'                   => 'Kabupaten',
            'province'                  => 'Porvinsi',
            'postal_code'               => 'Kode Pos',
        ];
    }

    public function messages()
    {
        return [
            'family_card_number'        => 'Nomor kartu keluaga harus diisi',
            'head_of_family_id'         => 'Kepala keluarga harus diisi',
            'address'                   => 'Alamat harus diisi',
            'rt'                        => 'RT harus diisi',
            'rw'                        => 'RW harus diisi',
            'hamlet'                    => 'Dusun harus diisi',
            'village'                   => 'Desa harus diisi',
            'distinct'                  => 'Kecamatan harus diisi',
            'regency'                   => 'Kabupaten harus diisi',
            'province'                  => 'Porvinsi harus diisi',
            'postal_code'               => 'kode pos harus diisi',
        ];
    }
}
