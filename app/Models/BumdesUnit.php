<?php

namespace App\Models;

use App\Models\Bumdes;
use App\Models\BumdesProduct;
use Illuminate\Database\Eloquent\Model;

class BumdesUnit extends Model
{
    use UUID;

    protected $fillable = [
        'bumdes_id',
        'name',
        'business_type',
        'description',
        'established_year',
        'status'
    ];

    public function bumdes()
    {
        return $this->belongsTo(Bumdes::class);
    }

    public function bumdesProduct()
    {
        return $this->hasMany(BumdesProduct::class);
    }
}
