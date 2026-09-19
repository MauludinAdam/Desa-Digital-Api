<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BumdesProductResource extends JsonResource
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
            'bumdes_unit_id'    => $this->bumdes_unit_id,
            'bumdesUnit'        => $this->whenLoaded('bumdesUnit'),
            'name'              => $this->name,
            'barcode'           => $this->barcode,
            'price'             => $this->price,
            'unit'              => $this->unit,
            'stock'             => $this->stock,
            'status'            => $this->status,
        ];
    }
}
