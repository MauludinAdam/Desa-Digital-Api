<?php

namespace App\Http\Requests\CitizenDocument;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CitizenDocumentUpdateRequest extends FormRequest
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
            'citizen_id'        => 'required|string|exists:citizens,id',
            'document_type'     => 'required|string|max:200',
            'file'              => 'mimes:pdf,jpg,png,jpeg|max:5120',
        ];
    }

    public function attributes()
    {
        return [
            'citizen_id'        => 'Penduduk',
            'document_type'     => 'Dokumen Penduduk',
            'file'              => 'File',
        ];
    }

    public function messages()
    {
        return [
            'citizen_id'        => ':attribute harus diisi',
            'document_type'     => ':attribute harus diisi',
            'file'              => ':attribute harus diisi',
            'mimes'             => ':attribute harus berupa PDF,JPG.PNG,JPEG',
            'max'               => ':attribute maksimal 5MB',
        ];
    }
}
