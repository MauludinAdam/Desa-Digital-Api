<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SOftDeletes;
use App\Traits\UUID;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use SoftDeletes, UUID;

    protected $fillabale = ['name'];
}
