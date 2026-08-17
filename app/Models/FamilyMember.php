<?php

namespace App\Models;

use App\Models\Citizen;
use App\Models\FamilyCard;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use UUID;

    protected $fillable = [
        'family_card_id',
        'citizen_id',
        'relationship',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('citizen', function($query) use ($search){
            $query->where('full_name', 'Like', "%{$search}%")
            ->orWhere('nik', 'Like', "%{$search}%");
        });
    }

    public function familyCard()
    {
        return $this->belongsTo(FamilyCard::class);
    }

    public function citizen()
    {
        return $this->belongsTo(Citizen::class, 'citizen_id','id');
    }
}
