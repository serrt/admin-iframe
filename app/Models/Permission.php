<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['id', 'name', 'pid', 'key', 'url', 'sort'];

    public $timestamps = false;

    public function parent()
    {
        return $this->hasOne(Permission::class, 'id', 'pid');
    }

    public function children()
    {
        return $this->hasMany(Permission::class, 'pid', 'id');
    }
}
