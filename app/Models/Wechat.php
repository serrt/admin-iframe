<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    protected $table = 'wechat';

    protected $fillable = ['id', 'role_id', 'type', 'name', 'logo', 'app_id', 'app_secret', 'scope', 'created_at', 'updated_at'];

    // 静默授权
    const SCOPE_BASE = 0;
    // 非静默授权
    const SCOPE_USERINFO = 1;
    // 微信公众号
    const TYPE_MP = 0;
    // 微信小程序
    const TYPE_MIN = 1;

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
