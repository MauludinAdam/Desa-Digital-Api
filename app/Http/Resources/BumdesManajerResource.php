<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BumdesManajerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,

            'bumdes_id'     => $this->bumdes_id,
            'bumdes'        => $this->whenLoaded('bumdes'),

            'name'          => $this->name,
            'position'      => $this->position,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'photo'         => $this->photo,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'status'        => 'active',
        ];
    }
}
