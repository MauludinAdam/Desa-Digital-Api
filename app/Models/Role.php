<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use UUID;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
