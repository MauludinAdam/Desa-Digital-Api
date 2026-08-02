<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class LetterType extends Model
{
    use SoftDeletes, UUID;
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'Like', "%{$search}%")
        ->orWhere('code', 'Like', "%{$search}%");
    }
}
