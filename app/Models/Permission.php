<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    protected $fillable = ['id', 'name', 'guard_name', 'pid', 'sort', 'display_name', 'menu', 'created_at', 'updated_at'];
}
