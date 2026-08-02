<?php

namespace App\Models;

use App\Models\CitizenDocument;
use App\Models\Education;
use App\Models\FamilyCard;
use App\Models\FamilyMember;
use App\Models\Letter;
use App\Models\Occupation;
use App\Models\Religion;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
use SoftDeletes, UUID;

    protected $fillable = [
        'family_card_id',
        'full_name',
        'nik',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'phone_number',
        'occupation_id',
        'religion_id',
        'education_id',
        'marital_status',
        'blood_type',
        'email',
        'nationality',
        'status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('full_name', 'like', "%{$search}%")
            ->orWhere('nik','like',"%{$search}%")
            ->orWhere('email', 'like',"%{$search}%");
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    public function headOfFamilyCard()
    {
        return $this->hasOne(FamilyCard::class, 'head_of_family_id');
    }

    public function citizenDocuments()
    {
        return $this->hasMany(CitizenDocument::class);
    }

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    public function familyCard()
    {
        return $this->belongsTo(FamilyCard::class);
    }
}
