<?php

namespace App\Models;

use App\Models\Citizen;
use App\Models\FamilyMember;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyCard extends Model
{
    use SoftDeletes, UUID, HasFactory;

    public $incrementing = false;

    protected $kyeType = 'string';

    protected $fillable = [
        'family_card_number',
        'head_of_family_id',
        'address',
        'rt',
        'rw',
        'hamlet',
        'village',
        'district',
        'regency',
        'province',
        'postal_code',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('headOfFamily', function($query) use ($search) {
            $query->where('full_name', 'Like', "%{$search}%");
        })->orWhere('family_card_number', 'Like', "%{$search}%");
    }

    public function headOfFamily()
    {
        return $this->belongsTo(Citizen::class, 'head_of_family_id');
    }

    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'family_card_id', 'id');
    }
}
