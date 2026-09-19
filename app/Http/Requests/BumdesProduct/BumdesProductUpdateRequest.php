<?php

namespace App\Http\Requests\BumdesProduct;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesProductUpdateRequest extends FormRequest
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
            'bumdes_unit_id'        => 'required|string|max:200',
            'name'                  => 'required|string|max:200',
            'barcode'               => 'required|string|max:200',
            'price'                 => 'required|string|max:200',
            'unit'                  => 'required|string|max:150',
            'stock'                 => 'required|integer|min:0',
            'status'                => 'required|string|max:200',
        ];
    }

    public function attributes()
    {
        return [
            'bumdes_unit_id'    => 'Unit Usaha',
            'name'              => 'Nama',
            'barcode'           => 'Barcode',
            'price'             => 'Harga',
            'unit'             => 'Unit',
            'stock'             => 'Stock',
            'status'            => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'bumdes_unit_id.required' => ':attribute harus diisi',
            'name.required'           => ':attribute harus diisi',
            'barcode.required'        => ':attribute harus diisi',
            'price.required'          => ':attribute harus diisi',
            'unit.required'          => ':attribute harus diisi',
            'stock.required'          => ':attribute harus diisi',
            'status.required'         => ':attribute harus diisi',
        ];
    }
}
