<?php

namespace App\Http\Requests\FamilyMember;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FamilyMemberStoreRequest extends FormRequest
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
            'family_card_id'        => 'required|string|max:200|exists:family_cards,id',
            'citizen_id'            => 'required|string|max:200|exists:citizens,id',
            'relationship'          => 'required|string|max:200|in:head_of_family,wife,husband,child,head_of_Family,parent,other'
        ];
    }

    public function attributes()
    {
        return [
            'family_card_id'    => 'Kartu keluarga',
            'citizen_id'        => 'Penduduk',
            'relationship'      => 'Hubungan',
        ];
    }

    public function messages()
    {
        return [
            'family_card_id'    => ':attribute harus diisi',
            'citizen_id'        => ':attribute harus diisi',
            'relationship'      => ':attribute harus diisi',
        ];
    }
}
