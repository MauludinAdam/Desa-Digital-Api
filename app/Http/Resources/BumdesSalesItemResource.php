<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BumdesSalesItemResource extends JsonResource
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
            'bumdes_sales_id'   => $this->bumdes_sales_id,
            'bumdesSales'       => $this->whenLoaded('bumdesSales'),

            'bumdes_product_id' => $this->bumdes_product_id,
            'bumdesProduct'     => $this->whenLoaded('bumdesProduct'),
            
            'quantity'          => $this->quantity,
            'price'             => $this->price,
            'subtotal'          => $this->subtotal,      
        ];
    }
}
