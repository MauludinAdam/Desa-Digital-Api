<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class ProfileVillage extends Model
{
    use UUID;
    
    protected $table = 'profiles';

    protected $fillable = [
        'thumbnail',
        'name',
        'district',
        'regency',
        'about',
        'headman',
        'people',
        'total_area',
    ];

}
