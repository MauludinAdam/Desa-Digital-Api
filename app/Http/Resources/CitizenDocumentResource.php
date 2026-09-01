<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitizenDocumentResource extends JsonResource
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
            'citizen'       => $this->whenLoaded('citizen'),
            'document_type' => $this->document_type,
            'file'          => $this->file ? asset('storage/'. $this->file) : null,
        ];
    }
}
