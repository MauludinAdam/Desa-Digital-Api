<?php

namespace App\Http\Requests\FamilyCard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FamilyCardUpdateRequest extends FormRequest
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
        $id = $this->route('family-card');
        return [
            'family_card_number'      => 'required|digits:16', Rule::unique('family_cards','family_card_number')->ignore($id),
            'head_of_family_id'       => 'nullable|string|max:255',
            'address'                 => 'required|string|max:500',
            'rt'                        => 'required|string|max:255',
            'rw'                        => 'required|string|max:255',
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
            'family_card_number'    => 'Nomor Kartu Keluarga',
            'head_of_family_id'     => 'Kepala keluarga',
            'address'               => 'Alamat',
            'rt'                    => 'RT',
            'rw'                    => 'RW',
            'hamlet'                => 'Dusun',
            'village'               => 'Desa',
            'distinct'              => 'Kecamatan',
            'regency'               => 'Kabupaten',
            'province'              => 'Provinsi',
            'postal_code'           => 'Kode Pos'
        ];
    }

    public function messages()
    {
        return [
            'family_card_number'    => 'Nomor kartu kerluatga harus diisi',
            'head_of_family_id'     => 'Kepala keluarga harus diisi',
            'address'               => ':attribute harus diisi',
            'rt'                    => ':attribute harus diisi',
            'rw'                    => ':attribute harus diisi',
            'hamlet'                => ':attribute harus diisi',
            'village'               => ':attribute harus diisi',
            'distinct'              => ':attribute harus diisi',
            'regency'               => ':attribute harus diisi',
            'province'              => ':attribute harus diisi',
            'postal_code'           => ':attribute harus diisi',
        ];
    }
}
