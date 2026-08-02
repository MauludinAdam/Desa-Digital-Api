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
            'letter_type_id'    => $this->letter_type_id,
            'letter_number'     => $this->letter_number,
            'purpose'           => $this->purpose,
            'status'            => 'pending',
            'rejection_reason'  => $this->rejection_reason,
            'approved_by'       => $this->approved_by,
            'approved_at'       => $this->approved_at
        ];
    }
}
