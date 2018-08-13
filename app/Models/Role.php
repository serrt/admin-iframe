<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['id', 'name', 'key'];

    public $timestamps = false;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    public function hasPermission($permission = [])
    {
        $query = $this->permissions();
        if (is_array($permission)) {
            $query->whereIn('permission_id', $permission);
        } else if (is_string($permission)) {
            $ar = explode(',', $permission);
            $query->whereIn('permission_id', $ar);
        } else {
            $query->where('permission_id', $permission);
        }
        return $query->count() > 0;
    }
}
