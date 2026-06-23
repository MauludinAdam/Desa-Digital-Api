<?php

namespace App\Models;

use App\Models\SosialAssistanceRecipient;
use Illuminate\Database\Eloquent\Model;

class SosialAssistance extends Model
{
    protected $fillable = [
        'thumbnail',
        'name',
        'category',
        'amount',
        'provider',
        'description',
        'is_available',
    ];

    public function sosialAssistanceRecepient()
    {
        return $this->hasMany(SosialAssistanceRecipient::class);
    }
}
