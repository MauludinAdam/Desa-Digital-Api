<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use SoftDeletes, UUID;


    protected $fillable = [
        'name',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'Like', "%{$search}%");
    }
}
