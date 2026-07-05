<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EventParticipantStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id'          => 'required|string|max:255',
            'head_of_family_id' => 'required|string|max:255',
            'quantity'         => 'required|numeric|min:0',
            'total_price'       => 'required|numeric|min:0',
            'payment_status'    => 'required|string|in:pending,paid,canceled',
        ];
    }

    public function attributes()
    {
        return [
            'event_id'          => 'Event',
            'head_of_family_id' => 'Kepala Keluarga',
            'quantity'          => 'Quantity',
            'total_price'       => 'Total Harga',
            'payment_status'    => 'Status Pembayaran',    
        ];
    }
}
