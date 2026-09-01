<?php

namespace App\Models;

use App\Models\Citizen;
use App\Models\FamilyCard;
use App\Models\LetterType;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
  use SoftDeletes, UUID;
  
  protected $fillable = [
    'citizen_id',
    'letter_type_id',
    'letter_number',
    'purpose',
    'status',
    'rejection_reason',
    'approved_by',
    'approved_at',
  ];

  public function scopeSearch($query, $search)
  {
    return $query->whereHas('citizen', function($query) use ($search) {
        $query->where('full_name','Like',"%{$search}%")
        ->orWhere('nik','Like',"{$search}");
    });
  }

  public function citizen()
  {
    return $this->belongsTo(Citizen::class);
  }

  public function letterType()
  {
    return $this->belongsTo(LetterType::class);
  }
}
