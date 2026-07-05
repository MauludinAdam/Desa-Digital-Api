<?php

namespace App\Models;

use App\Models\HeadOfFamily;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class FamilyMember extends Model
{
    use SoftDeletes, UUID;

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

    public function ScopeSearch($query, $search)
    {
        return $query->whereHas('user', function($query) use ($search) {
            $query->where('name', 'like',"%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->orWhere('identity_number','like', "%{$search}%");
    }

    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
