<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatPay extends Model
{
    protected $table = 'wechat_pay';

    protected $fillable = ['wechat_id', 'mch_id', 'key', 'cert_path', 'key_path', 'notify_url'];

    public function wechat()
    {
        return $this->hasOne(Wechat::class, 'id', 'wechat_id');
    }
}
