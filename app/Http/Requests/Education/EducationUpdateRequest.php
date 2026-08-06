<?php

namespace App\Http\Requests\Education;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EducationUpdateRequest extends FormRequest
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
            'name'      => 'required|string|max:200',
        ];
    }

    public function attributes()
    {
        return [
            'name'       => 'Nama',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute harus diisi',
        ];
    }
}
