<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'mst_user';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
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
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = crypt($value,$value);
    }
}
