<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $primaryKey = 'id';
    protected $relation = ['user_detail'];
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'user_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    protected $relations = ['terms_sub_teach'];
    public function user_detail(): HasOne
    {
        return $this->hasOne(Users_detail::class, 'id');
    }

    public function user_detail_all(): HasOne
    {
        return $this->hasOne(Users_detail::class, 'id');
    }


    public function committee()
    {
        return $this->hasMany(Course_committee::class, 'id');
    }
    public function terms_sub_teaches()
    {
        return $this->hasMany(Terms_sub_teach::class, 'id');
    }
}
