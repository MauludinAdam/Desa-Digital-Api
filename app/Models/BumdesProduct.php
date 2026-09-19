<?php

namespace App\Models;

use App\Models\Bumdes;
use App\Models\BumdesProduct;
use App\Models\BumdesUnit;
use App\Traits;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class BumdesProduct extends Model
{
    use UUID;

    protected $fillable = [
        'bumdes_unit_id',
        'name',
        'barcode',
        'price',
        'unit',
        'stock',
        'status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%");
    }

    public function bumdesUnit()
    {
        return $this->belongsTo(BumdesUnit::class);
    }

    public function bumdesProduct()
    {
        return $this->hasMany(BumdesProduct::class);
    }
}
