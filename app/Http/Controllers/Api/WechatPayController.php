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
            'key' => 'peidikejipeidikejipeidikejipeidi',   // API 密钥
            'cert_path' => '',
            'key_path' => '',
        ];

        $app = Factory::payment($config);

        $result = $app->order->unify([
            'body' => '叫你付钱',
            'out_trade_no' => date('YmdHis'),
            'total_fee' => 1,
            'notify_url' => 'https://www.baidu.com',
            'trade_type' => 'JSAPI',
            'openid' => $request->input('openid', 'oOx8B5TeeaNya-MBRyhYi7dpr3xQ'),
        ]);
        return $this->json($result);
    }
}
