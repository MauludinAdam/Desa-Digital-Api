<?php

namespace App\Models;

use App\Models\DevelopmentAplicant;
use Illuminate\Database\Eloquent\Model;

class Development extends Model
{
    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'person_in_charge',
        'start_date',
        'end_date',
        'amount',
        'status',
    ];

    public function developmentAplicant()
    {
        return $this->hasMany(DevelopmentAplicant::class);
    }
}
