<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LetterResource extends JsonResource
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
            'citizen_id'        => $this->citizen_id,
            'citizen'           => $this->whenLoaded('citizen'),

            'letter_type_id'    => $this->letter_type_id,
            'letter_type'       => $this->whenLoaded('letterType'),
            
            'letter_number'     => $this->letter_number,
            'purpose'           => $this->purpose,
            'status'            => $this->status,
            'rejection_reason'  => $this->rejection_reason,
            'approved_by'       => $this->approved_by,
            'approved_at'       => $this->approved_at,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
