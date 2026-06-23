<?php

namespace App\Models;

use App\Models\HeadOfFamily;
use App\Models\SosialAssistance;
use Illuminate\Database\Eloquent\Model;

class SosialAssistanceRecipient extends Model
{
    protected $fillable = [
        'sosial_assistance_id',
        'head_of_family_id',
        'bank',
        'amount',
        'reason',
        'account_number',
        'proof',
        'status',
    ];

    public function sosialAssistance()
    {
        return $this->belongsTo(SosialAssistance::class);
    }

    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
