<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitizenResource extends JsonResource
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
            'full_name'         => $this->full_name,
            'nik'               => $this->nik,
            'gender'            => $this->gender,
            'place_of_birth'    => $this->place_of_birth,
            'date_of_birth'     => $this->date_of_birth,
            'phone_number'      => $this->phone_number,
            'email'             => $this->email,
            'marital_status'             => $this->marital_status,
            'blood_type'             => $this->blood_type,
            'nationality'             => $this->nationality,
            'status'             => $this->status,
            'family_card'             => $this->whenLoaded('familyCard'),
            'occupation'            => $this->whenLoaded('occupation'),
            'education'            => $this->whenLoaded('education'),
            'religion'            => $this->religion,
            'documents'            => $this->whenLoaded('citizenDocuments'),
            'letters'            => $this->whenLoaded('letters'),
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
