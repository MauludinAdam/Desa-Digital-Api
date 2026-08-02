<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class FamilyCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'family_card_number'    => $this->family_card_number,
            'head_of_family_id'     => $this->head_of_family_id,
            'address'               => $this->address,
            'rt'                    => $this->rt,
            'rw'                    => $this->rw,
            'hamlet'                => $this->hamlet,
            'village'               => $this->village,
            'district'              => $this->district,
            'regency'               => $this->regency,
            'province'              => $this->province,
            'postal_code'           => $this->postal_code,
        ];
    }
}
