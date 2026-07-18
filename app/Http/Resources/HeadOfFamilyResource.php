<?php

namespace App\Http\Resources;

use App\Http\Resources\FamilyMemberResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeadOfFamilyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'user'  => new UserResource($this->user),
            'profile_picture'   => $this->profile_picture ? asset('storage/' .$this->profile_picture) : null,
            'identity_number'   => $this->identity_number,
            'gender'   => $this->gender,
            'date_birth'   => $this->date_birth,
            'phone_number'   => $this->phone_number,
            'occupation'   => $this->occupation,
            'marital_status'   => $this->marital_status, 
            'family_members'         => FamilyMemberResource::collection($this->familyMember)
        ];
    }
}
