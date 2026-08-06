<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;
class Religion extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = ['name'];
}
