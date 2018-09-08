<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatUser extends Model
{
    protected $fillable = ['id', 'role_id', 'wechat_id', 'openid', 'nickname', 'sex', 'headimgurl', 'api_token', 'created_at', 'updated_at'];

    protected $hidden = ['api_token'];

    public function save(array $options = [])
    {
        $this->api_token = static::getToken();
        return parent::save($options);
    }

    public function getApiTokenAttribute()
    {
        if (!$this->attributes['api_token']) {
            $this->attributes['api_token'] = static::getToken();
            $this->save();
        }
        return $this->attributes['api_token'];
    }

    public static function getToken()
    {
        return str_random(32);
    }
}
