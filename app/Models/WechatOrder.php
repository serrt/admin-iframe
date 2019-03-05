<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatOrder extends Model
{
    // 支付方式(micro_pay: 付款码, js_api: 微信网页, min_program: 小程序支付, native: 扫码支付, app: APP支付, h5: H5支付)
    const TYPE_MICRO = 'micro_pay';
    const TYPE_JS = 'js_api';
    const TYPE_MIN = 'min_program';
    const TYPE_NATIVE = 'native';
    const TYPE_APP = 'app';
    const TYPE_H5 = 'h5';

    public static $typeMap = [
        self::TYPE_MICRO => '付款码',
        self::TYPE_JS => '微信网页',
        self::TYPE_MIN => '小程序',
        self::TYPE_NATIVE => '扫码支付',
        self::TYPE_APP => 'APP支付',
        self::TYPE_H5 => 'H5支付',
    ];

    // 订单状态(1: 待支付, 2: 已支付, 3: 取消支付)
    const STATUS_FAIL = '-1';
    const STATUS_PROCESS = '1';
    const STATUS_SUCCESS = '2';
    const STATUS_CANCEL = '3';

    public static $statusMap = [
        self::STATUS_FAIL => '失败',
        self::STATUS_PROCESS => '未支付',
        self::STATUS_SUCCESS => '已支付',
        self::STATUS_CANCEL => '已取消',
    ];

    protected $table = 'wechat_orders';

    protected $fillable = ['user_id', 'wechat_id', 'pay_id', 'out_trade_no', 'body', 'type', 'money', 'status', 'success_time', 'cancel_time', 'remarks'];

    protected $dates = ['success_time', 'cancel_time'];

    protected $attributes = [
        'status' => self::STATUS_PROCESS,
    ];

    public function user()
    {
        return $this->belongsTo(WechatUser::class, 'user_id', 'id');
    }

    public function wechat()
    {
        return $this->belongsTo(Wechat::class, 'wechat_id', 'id');
    }

    public function pay()
    {
        return $this->belongsTo(WechatPay::class, 'pay_id', 'id');
    }

    public function getTypeNameAttribute()
    {
        return $this->attributes['type']?data_get(self::$typeMap, $this->attributes['type']):$this->attributes['type'];
    }

    public function getStatusNameAttribute()
    {
        return data_get(self::$statusMap, $this->attributes['status']);
    }

    public function getMoneyAttribute()
    {
        return $this->attributes['money']/100;
    }
}
