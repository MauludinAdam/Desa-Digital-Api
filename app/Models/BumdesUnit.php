<?php

namespace App\Models;

use App\Models\Bumdes;
use App\Models\BumdesProduct;
use App\Models\BumdesSales;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class BumdesUnit extends Model
{
    use UUID;

    protected $fillable = [
        'name',
        'business_type',
        'description',
        'established_year',
        'status'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    public function bumdesProduct()
    {
        return $this->hasMany(BumdesProduct::class);
    }

    public function bumdesSales()
    {
        return $this->hasMany(BumdesSales::class);
    }
}
