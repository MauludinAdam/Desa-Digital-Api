<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class BumdesManajer extends Model
{
    use UUID;

    protected $fillable = [
        'bumdes_id',
        'name',
        'position',
        'phone',
        'address',
        'photo',
        'start_yera',
        'end_year',
        'status',
    ];

    public function bumdes()
    {
        return $this->belongsTo(Bumdes::class);
    }
}
