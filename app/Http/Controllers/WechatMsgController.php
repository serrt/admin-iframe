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

    public function index(Request $request)
    {
        $app = $this->getWechat();
        $data = $app->material->list($request->input('type', 'news'), 0, 20);
        return $this->json($data);
    }

    public function send(Request $request)
    {
        $app = $this->getWechat();

        $media_id = $request->input('id');

        $result = $app->broadcasting->sendNews($media_id, explode(',', $request->input('openid')));
        return $this->json($result);
    }

    public function sendArticle(Request $request)
    {
        $article = new Article([
            'title'   => '熊猫吃竹子',
            'author'  => '秦瑞涵',
            'content' => '<h1>点开有惊喜!!</h1>',
            'source_url' => 'https://www.peidikeji.cn',
            'show_cover' => 1,
        ]);

        $app = $this->getWechat();

        $result = $app->broadcasting->sendMessage($article, explode(',', $request->input('openid')));

        return $this->json($result);
    }
}
