<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'role_id',
        'avatar',
    ];

    protected $with = [
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute(){
        if(!isset($this->attributes['avatar'])) return null;
        return str_starts_with($this->attributes['avatar'], 'http')
                ? $this->attributes['avatar']
                : url('storage') . '/' . $this->attributes['avatar'];
    }

    public function role(){
        return $this->belongsTo('App\Domain\General\Role\Model\Role');
    }

    public function roleName(){
        return $this->role->name;
    }

    public function isAdmin(){
        return $this->roleName() === 'admin';
    }

    public function isUser(){
        return $this->roleName() === 'user';
    }
}
