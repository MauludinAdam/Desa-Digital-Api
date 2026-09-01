<?php

namespace App\Http\Requests\CitizenDocument;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CitizenDocumentStoreRequest extends FormRequest
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
            'document_type'     => 'required|string|max:255',
            'file'              => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function attributes()
    {
        return [
            'citizen_id'        => 'Penduduk',
            'document_type'     => 'Dokument',
            'file'              => 'File',
        ];
    }

    public function messages()
    {
        return [
            'citizen_id'        => ':attribute harus diisi',
            'document_type'     => ':attribute harus diisi',
            'file'              => ':attribute harus diisi',
            'file.file'         => ':attribute harus berupa file',
            'file.mimes'        => ':attribute harus perupa PDF,JPG,JPEG, PNG',
            'file.max'          => ':attribute maksimal 5MB',
        ];
    }
}
