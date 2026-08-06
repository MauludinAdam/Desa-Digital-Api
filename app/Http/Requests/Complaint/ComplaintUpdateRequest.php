<?php

namespace App\Http\Requests\Complaint;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintUpdateRequest extends FormRequest
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
            'response'          => 'required|string|max:200',
        ];
    }

    public function attributes()
    {
        return [
            'citizen_id'        => 'Penduduk',
            'title'             => 'Judul',
            'description'       => 'Deskripsi',
            'response'          => 'Respon',
        ];
    }

    public function messages()
    {
        return [
            'citizen_id'    => ':atribute harus diisi',
            'title'         => ':attribute harus diisi',
            'discription'   => ':attribute harus diisi',
            'response'      => ':attribute harus diisi',
        ];
    }
}
