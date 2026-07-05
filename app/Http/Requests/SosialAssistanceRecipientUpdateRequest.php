<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SosialAssistanceRecipientUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sosial_assistance_id'      => 'required|string|max:255',
            'head_of_family_id'         => 'required|string|max:255',
            'bank'                      => 'required|string|in:bri,bni,bca,mandiri',
            'amount'                    => 'required',
            'reason'                    => 'required|string|max:255',
            'account_number'            => 'required|string|max:20',
            'proof'                     => 'nullable|string|max:255',
            'status'                    => 'nullable|string|in:pending,approved,rejected',
        ];  
    }

    public function attributes()
    {
        return [
            'sosial_assistance_id'      => 'Bantuan Sosial',
            'head_of_family_id'         => 'Kelapa Keluarga',
            'bank'                      => 'Bank',
            'amount'                    => 'Jumlah Bantuan',
            'reason'                    => 'Alasan',
            'account_number'            => 'Nomor Akun',
            'proof'                     => 'Bukti',
            'status'                    => 'Status',
        ];
    }
}
