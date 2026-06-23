<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class ProfileImage extends Model
{
    protected $fillable = [
        'profile_id',
        'image',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
