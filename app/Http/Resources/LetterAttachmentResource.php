<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LetterAttachmentResource extends JsonResource
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
            'letter_id'     => $this->letter_id,
            'file'          => $this->file ? asset('storage/' . $this->file) : null,
            'description'   => $this->description,
        ];
    }
}
