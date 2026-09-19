<?php

namespace App\Http\Requests\BumdesSales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BumdesSalesUpdateRequest extends FormRequest
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
            'invoice_number'        => 'required|string|max:150',
            'sale_date'             => 'required|date',
            'customer_name'         => 'required|string|max:200',
            'total_amount'          => 'required|string|max:100',
            'payment_method'        => 'required|string|max:100',
            'status'                => 'required|string|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'bumdes_unit_id'        => 'Bidang Usaha Bumdes',
            'invoice_number'        => 'Nomor Invoice',
            'sale_date'             => 'Tanggal Transaksi',
            'customer_name'         => 'Nama Customer',
            'total_amount'          => 'Jumlah Total',
            'payment_method'        => 'Metode Pembayaran',
            'status'                => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'bumdes_unit_id'        => 'attibute harus diisi',
            'invoice_number'        => ':attibute harus diisi',
            'sale_date'             => ':attibute harus diisi',
            'customer_name'         => ':attribute harus diisi',
            'total_amount'          => ':attribute harus diisi',
            'payment_method'        => ':attribute harus diisi',
            'status'                => ':attribute harus diisi',
        ];
    }
}
