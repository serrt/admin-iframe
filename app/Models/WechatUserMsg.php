<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatUserMsg extends Model
{
    protected $table = 'wechat_user_msg';

    protected $fillable = ['id', 'role_id', 'wechat_id', 'user_id', 'name', 'phone', 'address', 'province', 'city', 'area', 'remarks', 'created_at', 'updated_at'];

    public function wechat()
    {
        return $this->hasOne(Wechat::class, 'id', 'wechat_id');
    }

    public function user()
    {
        return $this->hasOne(WechatUser::class, 'id', 'user_id');
    }
}
