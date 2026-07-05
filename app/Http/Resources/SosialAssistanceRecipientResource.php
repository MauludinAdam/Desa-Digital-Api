<?php

namespace App\Http\Resources;

use App\Http\Resources\HeadOfFamilyResource;
use App\Http\Resources\SosialAssistanceResource;
use App\Models\HeadOfFamily;
use App\Models\SosialAssistance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SosialAssistanceRecipientResource extends JsonResource
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
            'sosial_assistance' => new SosialAssistanceResource($this->sosialAssistance),
            'head_of_family'    => new HeadOfFamilyResource($this->headOfFamily),
            'bank'              => $this->bank,
            'amount'            => $this->amount,
            'reason'            => $this->reason,
            'account_number'    => $this->account_number,
            'proof'             => $this->proof,
            'status'            => $this->status,
        ];
    }
}
