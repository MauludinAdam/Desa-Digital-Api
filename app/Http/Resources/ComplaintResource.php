<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
            'citizen_id'    => $this->citizen_id,
            'title'         => $this->title,
            'description'   => $this->description,
            'status'        => 'pending',
            'response'     => $this->response,
            'responded_by'  => $this->responded_by,
            'responded_at'  => $this->responded_at,
        ];
    }
}
