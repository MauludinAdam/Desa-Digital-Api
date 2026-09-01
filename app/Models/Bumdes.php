<?php

namespace App\Models;

use App\Models\BumdesManajer;
use App\Models\BumdesProduct;
use App\Models\BumdesUnit;
use App\Traits;
use Illuminate\Database\Eloquent\Model;

class Bumdes extends Model
{
    use UUID;

    protected $fillable = [
        'name',
        'legal_number',
        'established_yera',
        'address',
        'description',
        'logo',
    ];

    public function bumdesUnits()
    {
        return $this->hasMany(BumdesUnit::class);
    }

    public function bumdesManajers()
    {
        return $this->hasMany(BumdesManajer::class);
    }
}
