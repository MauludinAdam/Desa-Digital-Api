<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SosialAssistanceRecipient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class SosialAssistance extends Model
{
    use SoftDeletes, HasFactory, UUID;

    protected $fillable = [
        'thumbnail',
        'name',
        'category',
        'amount',
        'provider',
        'description',
        'is_available',
    ];

    protected $casts = [
        'is_available'  => 'boolean',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name','like', "%{$search}%")
            ->orWhere('provider', 'like', "%{$search}%")
            ->orWhere('amount', 'like', "%{$search}%");
    }

    public function sosialAssistanceRecepient()
    {
        return $this->hasMany(SosialAssistanceRecipient::class);
    }
}
