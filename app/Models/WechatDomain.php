<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatDomain extends Model
{
    protected $table = 'wechat_domain';

    protected $fillable = ['id', 'wechat_id', 'domain', 'path', 'created_at', 'updated_at'];

    public function wechat()
    {
        return $this->belongsTo(Wechat::class, 'wechat_id', 'id');
    }
}
