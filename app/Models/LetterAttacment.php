<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterAttacment extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = [
        'letter_id',
        'file',
        'description',
    ];

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
