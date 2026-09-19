<?php

namespace App\Http\Requests\BumdesSalesItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesSalesItemStoreRequest extends FormRequest
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
            'bumdes_sales_id'   => 'required|string|max:200',
            'bumdes_product_id' => 'required|string|max:200',
            'quantity'          => 'required|string|max:100',
            'price'             => 'required|string|max:100',
            'subtital'          => 'required|string|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'bumdes_sales_id'       => 'Penjual Bumdes',
            'bumdes_product_id'     => 'Product Bumdes',
            'quantity'              => 'Quantity',
            'price'                 => 'Harga',
            'subtotal'              => 'Subtotal',
        ];
    }

    public function messages()
    {
        return [
            'bumdes_sales_id'   => ':attribute harus diisi',
            'bumdes_product_id' => ':attribute harus diisi',
            'quantity'          => ':attribute harus diisi',
            'price'             => ':attribute harus diisi',
            'subtotal'          => ':attribute harus diisi',
        ];
    }
}
