<?php

namespace App\Http\Requests\Letter;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LetterStoreRequest extends FormRequest
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
            'citizen_id'        => 'required|exists:citizens,id',
            'letter_type_id'    => 'required|exists:letter_types,id', Rule::unique('letters', 'letter_type_id')
            ->where(fn ($query) => $query->where('citizen_id', $this->citizen_id)),
            'purpose'           => 'required|string|max:200',
            'status'            => 'nullable|string|max:200',
            'rejection_reason'  => 'nullable|string|max:500',
            'approved_by'       => 'nullable|string|max:255',
            'approved_at'       => 'nullable|date',      
        ];
    }

    public function attributes()
    {
        return [
            'citizen_id'        => 'Kepala keluarga',
            'letter_type_id'    => 'Jenis surat',
            'purpose'           => 'Tujuan',
            'status'            => 'Status',
            'rejection_reason'  => 'Alasan',
            'approved_by'       => 'Disetujui oleh',
            'approved_at'       => 'Disetujui pada'
        ];
    }

    public function messages()
    {
        return [
            'citizen_id'        => ':attribute harus diisi',
            'letter_type_id'    => ':attribute harus diisi',
            'unique'            => ':attribute sudah terdaftar',
            'purpose'           => ':attribute harus diisi',
            'status'            => ':attribute harus diisi',
            'rejection_reason'  => ':attribute harus diisi',
            'approved_by'       => ':atribute harus diisi',
            'approved_at'       => ':atribute harus diisi',
        ];
    }
}
