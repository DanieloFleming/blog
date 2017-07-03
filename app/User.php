<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should not be displayed (when model is echoed).
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
