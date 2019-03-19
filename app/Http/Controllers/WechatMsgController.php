<?php

namespace App\Http\Controllers;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Article;
use Illuminate\Http\Request;

class WechatMsgController extends Controller
{
    protected function getWechat()
    {
        $config = [
            'app_id' => 'wx58692e1ab1b2f7e5',
            'secret' => 'a2f460b01d918a7072559a3648482536',
            'response_type' => 'array',
        ];

        $app = Factory::officialAccount($config);
        return $app;
    }

    public function index()
    {
        $app = $this->getWechat();
        $data = $app->material->list('news', 0, 20);
        dd($data);
    }

    public function send(Request $request)
    {
        $app = $this->getWechat();

        $media_id = $request->input('id');

        $result = $app->broadcasting->sendNews($media_id, $request->input('openid'));
        return $this->json($result);
    }
}
