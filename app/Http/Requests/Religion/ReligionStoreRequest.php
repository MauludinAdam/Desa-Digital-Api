<?php

namespace App\Http\Requests\Religion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReligionStoreRequest extends FormRequest
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
            'name'      => 'required|string|max:200|unique:religions,name',
        ];
    }

    public function attributes()
    {
        return [
            'name'      => 'Nama',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute harus diisi',
            'unique'        => ':attribute tidak boleh sama',
        ];
    }
}
