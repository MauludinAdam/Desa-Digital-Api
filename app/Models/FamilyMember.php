<?php

namespace App\Models;

use App\Models\HeadOfFamily;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = [
        'head_of_family_id',
        'user_id',
        'profile_picture',
        'identity_number',
        'gender',
        'date_birth',
        'phone_number',
        'occupation',
        'marital_status',
        'relation',
    ];

    public function headOfFamily()
    {
        return $this->belongTo(HeadOfFamily::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
