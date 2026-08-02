<?php

namespace App\Models;

use App\Models\Citizen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class CitizenDocument extends Model
{
    use SoftDeletes, UUID;
    
    protected $fillable = [
        'citizen_id',
        'document_type',
        'file'
    ];

    public function citizen()
    {
        return $this->belongsTo(Citizen::class, 'citizen_id');
    }
}
