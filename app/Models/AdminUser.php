<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $fillable = ['id', 'username', 'password', 'name', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

    protected $rememberTokenName = '';

}
