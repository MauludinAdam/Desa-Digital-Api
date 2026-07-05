<?php

namespace App\Models;

use App\Models\EventParticipant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Event extends Model
{
    use SoftDeletes, UUID;
    
    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'price',
        'date',
        'time',
        'is_active',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name','like',"%{$search}%");
    }

    public function eventParticipant()
    {
        return $this->hasMany(EventParticipant::class);
    }
}
