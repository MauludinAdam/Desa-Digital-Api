<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UUID;

class FamilyCard extends Model
{
    use SoftDeletes, UUID, HasFactory;

    public $incrementing = false;

    protected $kyeType = 'string';

    protected $fillable = [
        'family_card_number',
        'head_of_family_id',
        'address',
        'rt',
        'rw',
        'hamlet',
        'village',
        'district',
        'regency',
        'province',
        'postal_code',
    ];

    public function headOfFamily()
    {
        return $this->belongsTo(Citizen::class, 'head_of_family_id');
    }

    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }
}
