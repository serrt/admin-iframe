<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatUser extends Model
{
    protected $fillable = ['id', 'role_id', 'wechat_id', 'openid', 'nickname', 'sex', 'headimgurl', 'api_token', 'created_at', 'updated_at'];

    protected $hidden = ['api_token'];

    public function save(array $options = [])
    {
        $this->api_token = str_random(32);
        return parent::save($options);
    }
}
