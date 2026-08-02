<?php

namespace App\Models;

use App\Models\SosialAssistance;
// use App\Traits\UUID;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\factories\HasFactory;

class SosialAssistanceCategory extends Model
{
    use SoftDeletes, HasFactory, HasUuids;

    protected $fillable = [
        'name', 
        'description'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    public function sosialAssistance()
    {
        return $this->hasMany(SosialAssistance::class);
    }
}
