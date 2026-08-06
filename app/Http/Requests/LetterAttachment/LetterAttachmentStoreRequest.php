<?php

namespace App\Http\Requests\LetterAttachment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LetterAttachmentStoreRequest extends FormRequest
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
            'letter_id'            => 'required|string|max:200',
            'file'                  => 'required|string|max:200',
            'description'           => 'required|string|max:500',
        ];
    }

    public function attributes()
    {
        return [
            'letter_id'        => 'Surat',
            'file'              => 'File',
            'description'       => 'Deskripsi',
        ];
    }

    public function messages()
    {
        return [
            'letter_id.required'       => ':attribute harus diisi',
            'file.required'             => ':attribute harus diisi',
            'description.required'      => ':attribute harus diisi',        
        ];
    }
}
