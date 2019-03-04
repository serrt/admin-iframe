<?php

namespace App\Http\Controllers\Api;

use EasyWeChat\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatPayController extends Controller
{
    public function pay(Request $request)
    {
        $config = [
            'app_id' => 'wxec1c45c29335c420',
            'mch_id' => '1502982171',
            'key' => 'peidikejipeidikejipeidikejipeidi',
            'cert_path' => '',
            'key_path' => '',
        ];

        $app = Factory::payment($config);

        $result = $app->order->unify([
            'body' => $request->input('body', '叫你付钱'),
            'out_trade_no' => $request->input('out_trade_no', date('YmdHis')),
            'total_fee' => $request->input('money', 1),
            'notify_url' => $request->input('notify_url', 'https://www.baidu.com'),
            'trade_type' => 'JSAPI',
            'openid' => $request->input('openid', 'oOx8B5TeeaNya-MBRyhYi7dpr3xQ'),
        ]);

        $jssdk = $app->jssdk;

        if (data_get($result, 'return_code') != 'SUCCESS') {
            return $this->error(data_get($result, 'return_msg'));
        } elseif (data_get($result, 'result_code') != 'SUCCESS') {
            return $this->error(data_get($result, 'err_code_des'));
        }

        $prepay_id = data_get($result, 'prepay_id');
        if (!$prepay_id) {
            return $this->error('系统错误, 请稍后再试');
        }

        $config = $jssdk->sdkConfig($prepay_id);

        return $this->json($config);
    }
}
