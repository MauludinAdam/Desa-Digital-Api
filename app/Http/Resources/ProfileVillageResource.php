<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileVillageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'              => $this->name,
            'thumbnail'         => $this->thumbnail ? asset('storage/' .$this->thumbnail) : null,
            'district'          => $this->district,
            'regency'           => $this->regency,
            'about'             => $this->about,
            'headman'           => $this->headman,
            'people'            => $this->people,
            'total_area'        => $this->total_area,

        ];
    }
}
