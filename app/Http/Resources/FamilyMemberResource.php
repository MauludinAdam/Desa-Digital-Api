<?php

namespace App\Http\Resources;

use App\Http\Resources\HeadOfFamilyResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'head_of_family'        => new HeadOfFamilyResource($this->whenLoaded('headOfFamily')),
            'user'                  => new UserResource($this->user),
            'profile_picture'       => $this->profile_picture,
            'identity_number'       => $this->identity_number,
            'gender'                => $this->gender,
            'date_birth'            => $this->date_birth,
            'phone_number'          => $this->phone_number,
            'occuptaion'            => $this->occuptaion,
            'marital_status'        => $this->marital_status,
            'relation'              => $this->relation,
        ];
    }
}
