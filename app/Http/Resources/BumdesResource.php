<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BumdesResource extends JsonResource
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
            'name'              => $this->name,
            'legal_number'      => $this->legal_number,
            'established_year'  => $this->established_year,
            'address'           => $this->address,
            'description'       => $this->description,
            'logo'              => $this->logo,
        ];
    }
}
