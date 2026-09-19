<?php

namespace App\Models;

use App\Models\BumdesManajer;
use App\Models\BumdesProduct;
use App\Models\BumdesUnit;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Bumdes extends Model
{
    use UUID;

    protected $fillable = [
        'name',
        'title',
        'legal_number',
        'established_year',
        'address',
        'description',
        'logo',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    public function bumdesManajers()
    {
        return $this->hasMany(BumdesManajer::class);
    }
}
