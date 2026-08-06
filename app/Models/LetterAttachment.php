<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class LetterAttachment extends Model
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
