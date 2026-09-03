<?php

namespace App\Models;

use App\Models\Bumdes;
use App\Models\BumdesUnit;
use App\Traits;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class BumdesProduct extends Model
{
    use UUID;

    protected $fillable = [
        'bumdes_unit_id',
        'name',
        'price',
        'photo',
        'type',
        'status',
    ];

    public function bumdesUnit()
    {
        return $this->belongsTo(BumdesUnit::class);
    }
}
