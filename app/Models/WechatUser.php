<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatUser extends Model
{
    protected $fillable = ['id', 'role_id', 'wechat_id', 'openid', 'nickname', 'sex', 'headimgurl', 'avatar_oss', 'province', 'city', 'api_token', 'session_key', 'created_at', 'updated_at'];

    protected $hidden = ['api_token'];

    public function wechat()
    {
        return $this->hasOne(Wechat::class, 'id', 'wechat_id');
    }

    public function messages()
    {
        return $this->hasMany(WechatUserMsg::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function save(array $options = [])
    {
        if (!$this->api_token) {
            $this->api_token = static::getToken($this->openid);
        }
        return parent::save($options);
    }

    public static function getToken($slat = '')
    {
        if ($slat) {
            $slat = str_random(32);
        }
        $token = md5($slat);
        if (WechatUser::where('api_token', $token)->exists()) {
            $token = WechatUser::getToken($slat);
        }
        return $token;
    }
}
