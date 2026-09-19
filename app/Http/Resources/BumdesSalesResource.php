<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BumdesSalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'invoice_number'    => $this->invoice_number,
            'sale_date'         => $this->sale_date,
            'customer_name'     => $this->customer_name,
            'total_amount'      => $this->total_amount,
            'payment_method'    => $this->payment_method,
            'status'            => $this->status,

            'bumdesSalesItem'   => $this->whenLoaded('bumdesSalesItem', 
            function() {
                return $this->bumdesSalesItem->map(function ($item) {
                    return [
                        'id'    => $item->id,
                        'bumdes_product_id' => $item->bumdes_product_id,
                        'quantity'  => $item->quantity,
                        'price'     => $item->price,
                        'subtotal'  => $item->subtotal,

                        'bumdesProduct' => $item->bumdesProduct ? [
                            'id'    => $item->bumdesProduct->id,
                            'name'  => $item->bumdesProduct->name,
                            'unit'  => $item->bumdesProduct->unit,
                        ] : null,
                    ];
                });
            }),
        ];
    }
}
