<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SosialAssistanceResource extends JsonResource
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
            'category_id'       => $this->category_id,
            'amount'            => $this->amount,
            'provider'          => $this->provider,
            'description'       => $this->description,
            'is_available'      => $this->is_available,
        ];
    }
}
