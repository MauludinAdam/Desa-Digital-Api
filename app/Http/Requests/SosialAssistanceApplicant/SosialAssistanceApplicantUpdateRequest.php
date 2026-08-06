<?php

namespace App\Http\Requests\SosialAssistanceApplicant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SosialAssistanceApplicantUpdateRequest extends FormRequest
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
            'sosial_assistance_id'      => 'required|string|max:200',
            'citizen_id'                => 'required|string|max:200',
            'bank'                      => 'required|string|max:200',
            'amount'                    => 'required|string|max:200',
            'reason'                    => 'required|string|max:200',
            'account_number'            => 'required|string|max:200',
            'rejection_reason'          => 'required|string|max:500',
        ];
    }

    public function attributes()
    {
        return [
            'sosial_assistance_id'      => 'Bantuan sosial',
            'citizen_id'                => 'Penduduk',
            'bank'                      => 'Bank',
            'amount'                    => 'Jumlah',
            'reason'                    => 'Alasan',
            'account_number'            => 'Nomor rekening',
            'rejection_reason'          => 'Alasan menolak',
        ];
    }

    public function messages()
    {
        return [
            'sosial_assistance_id'  => ':attribute harus diisi',
            'citizen_id'            => ':attribute harus diisi',
            'bank'                  => ':attribute harus diisi',
            'amount'                => ':attribute harus diisi',
            'reason'                => ':attribute harus diisi',
            'account_number'        => ':attribute harus diisi',
            'rejection_reason'      => ':attribute harus diisi',        
        ];
    }
}
