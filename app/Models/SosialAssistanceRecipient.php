<?php

namespace App\Models;

use App\Models\HeadOfFamily;
use App\Models\SosialAssistance;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SosialAssistanceRecipient extends Model
{
    use SoftDeletes, UUID, HasFactory;
    
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

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('headOfFamily', function($query) use($search) {
            $query->whereHas('user', function($query) use ($search) {
                $query->where('name','like', "%{$search}%")
                ->orWhere('email','like',"%{$search}%");
            });
        });
    }

    public function sosialAssistance()
    {
        return $this->belongsTo(SosialAssistance::class);
    }

    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
