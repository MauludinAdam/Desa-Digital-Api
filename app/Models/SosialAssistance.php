<?php

namespace App\Models;

use App\Models\SosialAssistanceApplicant;
use App\Models\SosialAssistanceCategory;
use App\Models\Category;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SosialAssistance extends Model
{
    use SoftDeletes, HasFactory, UUID;

    protected $fillable = [
        'name',
        'category_id',
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

    public function sosialAssistanceApplicant()
    {
        return $this->hasMany(SosialAssistanceApplicant::class);
    }

    public function category()
    {
        return $this->belongsTo(SosialAssistanceCategory::class, 'category_id');
    }
}
