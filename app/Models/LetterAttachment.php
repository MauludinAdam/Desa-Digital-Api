<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class LetterAttachment extends Model
{
    use UUID;

    protected $fillable = [
        'letter_id',
        'file',
        'description',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('letter', function($query) use ($search){
            $query->where('name','Like', "%{$search}%");
        });
    }

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
