<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatOss extends Model
{
    protected $table = 'wechat_oss';

    protected $fillable = ['id', 'wechat_id', 'access_key', 'access_secret', 'bucket', 'endpoint', 'ssl', 'isCName', 'cdnDomain', 'created_at', 'updated_at'];

    public function wechat()
    {
        return $this->belongsTo(Wechat::class, 'wechat_id', 'id');
    }

    public function getConfig()
    {
        $oss = $this;
        $config_file = 'filesystems.disks.oss';
        $config = [
            $config_file.'.access_id' => $oss->access_key,
            $config_file.'.access_key' => $oss->access_secret,
            $config_file.'.bucket' => $oss->bucket,
            $config_file.'.endpoint' => $oss->endpoint,
            $config_file.'.ssl' => $oss->ssl?true:False,
            $config_file.'.isCName' => $oss->isCName?true:False,
            $config_file.'.cdnDomain' => $oss->cdnDomain,
        ];
        return $config;
    }
}
