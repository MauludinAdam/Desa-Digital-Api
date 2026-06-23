<?php

namespace App\Models;

use App\Models\EventParticipant;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'price',
        'date',
        'time',
        'is_active',
    ];

    public function eventParticipant()
    {
        return $this->hasMany(EventParticipant::class);
    }
}
