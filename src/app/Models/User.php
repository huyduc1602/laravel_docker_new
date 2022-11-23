<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable
     * 
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'recovery_code',
    ];

    /**
     * 
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 
     * @var array<string,string>
     */
    protected $cast = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Auto encrypt password when update
     * 
     * @param $value
     * 
     * @return string
     */
    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }
}
