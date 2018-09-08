<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Wechat extends Model
{
    protected $table = 'wechat';

    protected $fillable = ['id', 'role_id', 'type', 'name', 'logo', 'app_id', 'app_secret', 'redirect_url', 'success_url', 'scope', 'created_at', 'updated_at'];

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

    public function setLogoAttribute($file = null)
    {
        if (gettype($file) == 'object') {
            $this->attributes['logo'] = Storage::url(Storage::putFile('logo/'.date('Y-m-d'), $file));
        } else if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $file, $result)) {
            $type = $result[2];
            if(in_array($type,array('jpeg','jpg','gif','bmp','png'))) {
                $savePath = 'logo/' . date('Y-m-d') . '/' . uniqid() . '.' . $type;
                Storage::put($savePath, base64_decode(str_replace($result[1], '', $file)));
                $this->attributes['logo'] = Storage::url($savePath);
            }
        } else {
            $this->attributes['logo'] = $file;
        }
    }

    public function getAuthUrlAttribute()
    {
        return route('wechat.index', ['app_id'=>$this->attributes['app_id']]);
    }
}
