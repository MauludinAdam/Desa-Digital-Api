<?php

namespace App\Http\Requests\SosialAssistance;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SosialAssistanceStoreRequest extends FormRequest
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
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|string|exists:sosial_assistance_categories,id',
            'amount'        => 'required|string|max:200',
            'provider'      => 'required|string|max:200',
            'description'   => 'required|string|max:500',
            'is_available'  => 'nullable|string|max:20',
        ];
    }

    public function attributes()
    {
        return [
            'name'          => 'Nama',
            'category_id'   => 'Kategori',
            'amount'        => 'Jumlah',
            'provider'      => 'Penyedia',
            'description'   => 'Deskripsi',
            'is_available'  => 'Is_available'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => ':attribute harus diisi',
            'category_id.required'  => ':attribute harus diisi',
            'amount.required'       => ':attribute harus diisi',
            'provider.required'     => ':attribute harus diisi',
            'description.required'  => ':attribute harus diisi',
            'is_available.required' => ':attribute harus diisi',
        ];
    }
}
