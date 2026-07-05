<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SosialAssistanceRecipientStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sosial_assistance_id'  => 'required|exists:sosial_assistances,id',
            'head_of_family_id'     => 'required|exists:head_of_families,id',
            'bank'                  => 'required|string|max:255|in:bri,bni,mandiri,bca',
            'amount'                => 'required',
            'reason'                => 'required|string|max:255',
            'account_number'        => 'required|string|max:20',
            'proof'                 => 'nullable|string|max:255',
            'status'                => 'nullable|string|in:pending,approved,rejected',     
        ];
    }

    public function attributes()
    {
        return [
            'sosial_assistance_id'      => 'Bantuan Sosial',
            'head_of_family_id'         => 'Kepala keluarga',
            'bank'                      => 'Bank',
            'amount'                    => 'Jumlah Bantuan',
            'reason'                    => 'Alasan',
            'account_number'            => 'Nomor Akun',
            'proof'                     => 'Bukti',
            'status'                    => 'Status',
        ];
    }
}
