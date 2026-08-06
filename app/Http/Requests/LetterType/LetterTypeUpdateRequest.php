<?php

namespace App\Http\Requests\LetterType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LetterTypeUpdateRequest extends FormRequest
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
            'name'          => 'required|string|max:200',
            'code'          => 'required|string|max:200',
            'description'   => 'required|string|max:500',
        ];
    }
    
    public function attributes()
    {
        return [
            'name'          => 'Nama',
            'code'          => 'Kode',
            'description'   => 'Deskripsi',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => ':attribute harus diisi',
            'code.required'         => ':attribute harus diisi',
            'description.required'  => ':attribute harus diisi',
        ];
    }
}
