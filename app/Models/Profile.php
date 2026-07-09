<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Profile extends Model
{
    use UUID;
    
    protected $fillable = [
        'thumbnail',
        'name',
        'about',
        'headmant',
        'people',
        'agricultural_area',
        'total_area',
    ];

    protected $scats = [
        'agricultural_area' => 'decimal:2',
        'total_area'        => 'decimal:2'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('people', 'like', "%{$search}%");
    }

    public function profileImage()
    {
        return $this->hasMany(ProfileImage::class);
    }
}
