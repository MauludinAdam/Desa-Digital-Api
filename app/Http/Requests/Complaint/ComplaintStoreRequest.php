<?php

namespace App\Http\Requests\Complaint;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintStoreRequest extends FormRequest
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
            'citizen_id'        => 'required|string|max:200',
            'title'             => 'required|string|max:200',
            'description'       => 'required|string|max:500',
            'response'         => 'required|string|max:200',
            'responded_by'      => 'nullable|string|max:200',
            'responded_at'      => 'nullable|string|max:200',
        ];
    }

    public function attributes()
    {
        return [
            'citizen_id'        => 'Penduduk',
            'title'             => 'Judul',
            'description'       => 'Deskripsi',
            'response'          => 'Respon',
            'responded_by'      => 'Responded_by',
            'responded_at'      => 'Responded_at'
        ];
    }

    public function messages()
    {
        return [
            'citizen_id'        => ':attribute harus diisi',
            'title'             => ':attribute harus diisi',
            'description'       => ':attribute harus diisi',
            'response'          => ':attribute harus diisi',
        ];
    }
}
