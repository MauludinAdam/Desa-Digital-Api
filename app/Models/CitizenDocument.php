<?php

namespace App\Models;

use App\Models\Citizen;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class CitizenDocument extends Model
{
    use UUID;
    
    protected $fillable = [
        'citizen_id',
        'document_type',
        'file'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('citizen', function($query) use ($search){
            $query->where('full_name', 'Like', "%{$search}%");
        });
    }

    public function citizen()
    {
        return $this->belongsTo(Citizen::class, 'citizen_id');
    }
}
