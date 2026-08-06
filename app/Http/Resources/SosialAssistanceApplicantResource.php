<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SosialAssistanceApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->id,
            'sosial_assistance_id'      => $this->sosial_assistance_id,
            'citizen_id'                => $this->citizen_id,
            'bank'                      => $this->bank,
            'amount'                    => $this->amount,
            'reason'                    => $this->reason,
            'rejection_reason'          => $this->rejection_reason,
            'account_number'            => $this->account_number,
            'status'                    => 'pending',
        ];
    }
}
