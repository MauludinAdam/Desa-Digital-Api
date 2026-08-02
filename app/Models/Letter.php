<?php

namespace App\Models;

use App\Models\Citizen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

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
        ->orWhere('nik','Like',"{$search}")
        ->orWhere('email','Like',"%{$search}");
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
