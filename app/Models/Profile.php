<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'thumbnail',
        'name',
        'about',
        'headmant',
        'people',
        'agricultural_area',
        'total_area',
    ];

    public function profileImage()
    {
        return $this->hasMany(ProfileImage::class);
    }
}
