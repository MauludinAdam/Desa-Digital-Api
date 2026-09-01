<?php

namespace App\Models;

use App\Models\Citizen;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Complaint extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = [
        'citizen_id',
        'title',
        'description',
        'status',
        'response',
        'responded_by',
        'responded_at',
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

    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
