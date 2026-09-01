<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\DevelopmentApplicant;
use App\Models\FamilyMember;
use App\Models\HeadOfFamily;
// use App\Traits\UUID;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    // use HasApiTokens, HasFactory, Notifiable, UUID, HasRoles;
    use HasApiTokens, HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name','like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
    }

    public function headOfFamily()
    {
        return $this->hasOne(HeadOfFamily::class);
    }

    public function familyMember()
    {
        return $this->hasOne(FamilyMember::class);
    }

    public function developmentAplicant()
    {
        return $this->hasMany(DevelopmentAplicant::class);
    }


    public function sendPasswordResetNotification($token)
    {
        

            $this->notify(new ResetPasswordNotification($token));
    }
}
