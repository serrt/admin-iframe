<?php

namespace App\Models;

use EasyWeChat\Factory;
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

    public static $typeMap = [
        self::TYPE_MP => '公众号',
        self::TYPE_MIN => '小程序'
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function oss()
    {
        return $this->hasOne(WechatOss::class, 'wechat_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(WechatUser::class, 'wechat_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(WechatUserMsg::class, 'wechat_id', 'id');
    }

    public function pays()
    {
        return $this->hasMany(WechatPay::class, 'wechat_id', 'id');
    }

    public function pay()
    {
        return $this->hasOne(WechatPay::class, 'wechat_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(WechatOrder::class, 'wechat_id', 'id');
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

    public function getTypeNameAttribute()
    {
        return data_get(self::$typeMap, $this->attributes['type'], '未知类型');
    }

    public function getAuthUrlAttribute()
    {
        return route('wechat.index', ['app_id'=>$this->attributes['app_id']]);
    }

    public function getStorage()
    {
        $oss = $this->oss;
        $disk = '';
        if ($oss && $oss->access_key && $oss->access_secret) {
            $disk = 'oss';
            $config = $oss->getConfig();
            config($config);
        }
        $storage = Storage::disk($disk);
        return $storage;
    }

    public function getPayment()
    {
        $pay = $this->pay;
        if (!$pay || !$pay->mch_id) {
            return false;
        }

        $config = [
            'app_id' => $this->attributes['app_id'],
            'mch_id' => $pay->mch_id,
            'key' => $pay->key,
            'cert_path' => $pay->cert_path,
            'key_path' => $pay->key_path,
            'notify_url' => $pay->notify_url,
        ];

        $app = Factory::payment($config);

        return $app;
    }
}
