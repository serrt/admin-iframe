<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    protected $fillable = ['id', 'username', 'password', 'name', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

    protected $rememberTokenName = '';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_user_roles', 'role_id', 'user_id');
    }

    public function permissions()
    {
        $permissions = collect();
        if ($this->isAdmin()) {
            $permissions = Permission::get();
        } else {
            $roles = $this->roles()->with('permissions')->get();
            foreach ($roles as $role) {
                $permissions = $permissions->concat($role->permissions);
            }
        }
        return $permissions;
    }

    public function hasRole($role = [])
    {
        $query = $this->roles;
        if (!$role) {
            return false;
        }
        if (is_array($role)) {
            $query = $query->whereIn('id', $role);
        } else if (is_string($role) && str_contains($role, ',')) {
            $ar = explode(',', $role);
            $query = $query->whereIn('id', $ar);
        } else {
            $query = $query->where('id', $role);
        }
        return $query->count() > 0;
    }

    public function isAdmin()
    {
        return $this->username == 'admin';
    }
}
