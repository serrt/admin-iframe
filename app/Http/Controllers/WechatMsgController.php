<?php

namespace App\Http\Controllers;

use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
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

    public function sendMessage(Request $request)
    {
        $items = [
            new NewsItem([
                'title'       => '熊猫吃锤子',
                'description' => '熊猫喜欢吃锤子',
                'url'         => 'http://www.peidikeji.cn',
                'image'       => 'https://qiniu.abcdefg.fun/act-pic3.png',
            ]),
        ];
        $news = new News($items);

        $app = $this->getWechat();

        $result = $app->customer_service->message($news)->to($request->input('openid'))->send();

        return $this->json($result);
    }

    public function addArticle(Request $request)
    {
        $app = $this->getWechat();
        $article = new Article([
            'title' => '熊猫吃竹子',
            'author' => '秦瑞涵',
            'content' => '<h1>点开有惊喜!!</h1>',
            'thumb_media_id' => $request->input('thumb_media_id'),
            'source_url' => 'https://www.peidikeji.cn',
            'show_cover' => 1,
        ]);


        $result = $app->material->uploadArticle($article);

        return $this->json($result);
    }

    public function sendArticle(Request $request)
    {
        $app = $this->getWechat();
        $result = $app->broadcasting->previewNews($request->input('media_id'), $request->input('openid'));

        return $this->json($result);
    }
}
