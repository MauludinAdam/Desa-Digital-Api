<?php

namespace App\Models;

use App\Models\EventParticipant;
use App\Models\FamilyMember;
use App\Models\SosialAssistanceRecipient;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class HeadOfFamily extends Model
{
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
