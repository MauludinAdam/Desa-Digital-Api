<?php

namespace App\Models;

use App\Models\Development;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DevelopmentAplicant extends Model
{
    protected $fillable = [
        'development_id',
        'user_id',
        'status',
    ];

    public function development()
    {
        return $this->belongsTo(Development::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
