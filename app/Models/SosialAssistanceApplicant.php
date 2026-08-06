<?php

namespace App\Models;

use App\Models\Citizen;
use App\Models\SosialAssistance;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SosialAssistanceApplicant extends Model
{
    use SoftDeletes, UUID, HasFactory;
    
    protected $fillable = [
        'sosial_assistance_id',
        'citizen_id',
        'bank',
        'amount',
        'reason',
        'account_number',
        'rejection_reason',
        'status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('citizen', function($query) use($search) {
                $query->where('name','like', "%{$search}%")
                ->orWhere('email','like',"%{$search}%");
            });
    }

    public function sosialAssistance()
    {
        return $this->belongsTo(SosialAssistance::class);
    }

    public function citizen()
    {
        return $this->belongsTo(Citizen::class);
    }
}
