<?php

namespace App\Models;

use App\Models\EventParticipant;
use App\Models\FamilyMember;
use App\Models\SosialAssistanceRecipient;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class HeadOfFamily extends Model
{
    use SoftDeletes, UUID;
    
    protected $fillable = [
        'user_id',
        'profile_picture',
        'identity_number',
        'gender',
        'date_birth',
        'phone_number',
        'occupation',
        'marital_status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('user', function ($query) use ($search){
            $query->where('name','like', "%{$search}%")
                ->orWhere('email','like', "%{$search}%");
        })->orWhere('identity_number','like',"%{$search}%");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function familyMember()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function sosialAssistanceRecepient()
    {
        return $this->hasMany(SosialAssistanceRecipient::class);
    }

    public function eventParticipant()
    {
        return $this->hasMany(EventParticipant::class);
    }
}
