<?php

namespace App\Http\Requests\BumdesSales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesSalesStoreRequest extends FormRequest
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
            'invoice_number'    => 'required|string|max:100',
            'sale_date'         => 'required|date',
            'customer_name'     => 'required|string|max:200',
            'total_amount'      => 'required|numeric|min:0',
            'payment_method'    => 'required|string|max:100',
            'status'            => 'required|string|max:100',

            'items'             => 'required|array|min:1',
            'items.*.bumdes_product_id' => 'required|uuid',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.subtotal'  => 'required|numeric|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'invioce_number'    => 'Nomor Invoice',
            'sale_date'         => 'Tanggal Transaksi',
            'customer_name'     => 'Nama Customer',
            'total_amount'      => 'Total Pembayaran',
            'payment_method'    => 'Metode Pembayaran',
            'status'            => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'invoice_number'        => ':attribute harus diisi',
            'sale_date'             => ':attribute harus diisi',
            'customer_name'         => ':attribute harus diisi',
            'total_amount'          => ':attribute harus diisi',
            'total_amount.numeric'  => ':attribute harus berupa angka',
            'payment_method'        => ':attribute harus diisi',
            'status'                => ':attribute harus diisi',
        ];
    }
}
