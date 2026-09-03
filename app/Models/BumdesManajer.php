<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

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
        'start_date',
        'end_date',
        'status',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    public function bumdes()
    {
        return $this->belongsTo(Bumdes::class);
    }
}
