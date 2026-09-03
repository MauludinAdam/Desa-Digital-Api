<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BumdesUnitResource extends JsonResource
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
            'bumdes_id'         => $this->bumdes_id,
            'bumdes'            => $this->whenLoaded('bumdes'),
            'name'              => $this->name,
            'business_type'     => $this->business_type,
            'description'       => $this->description,
            'established_year'  => $this->established_year,
            'status'            => $this->status
        ];
    }
}
