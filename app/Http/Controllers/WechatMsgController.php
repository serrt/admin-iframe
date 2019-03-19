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
            'title' => '2019年3月7日上午，钟湾村庆祝“三八”妇女节趣味游戏活动',
            'author' => '秦瑞涵',
            'content' => '<p style="margin-top: 0cm; margin-right: 0cm; margin-bottom: 0.0001pt; text-align: justify; font-size: 14px; font-family: Calibri, sans-serif;">
	<br>
</p>

<p style="margin-top: 0cm; margin-right: 0cm; margin-bottom: 0.0001pt; text-align: justify; font-size: 14px; font-family: Calibri, sans-serif;"><span style="font-size:21px;font-family:仿宋;color:#333333;">&nbsp; &nbsp; &ldquo;三八国际</span><a href="https://www.liuxue86.com/jiejiari/funvjie/" target="_blank"><span style="font-size:21px;font-family:仿宋;color:#333333;text-decoration:none;">妇女节</span></a><span style="font-size:21px;font-family:仿宋;color:#333333;">&rdquo;来临之际，为了纪念这一节日，让全村广大妇女享受到作为女性的幸福和快乐，感受到村两委会对妇女的关怀和爱护，3月7日上午，在钟湾村新便民服务中心举行了以&ldquo;幸福与快乐同在&rdquo;为主题的</span><a href="https://www.liuxue86.com/youxi/" target="_blank"><span style="font-size:21px;font-family:仿宋;color:#333333;text-decoration:none;">游戏</span></a><span style="font-size:21px;font-family:仿宋;color:#333333;">活动来庆祝这个特别的节日。</span></p>

<p style=\'margin:0cm;margin-bottom:.0001pt;text-align:justify;font-size:14px;font-family:"Calibri","sans-serif";\'><span style="font-size:21px;font-family:仿宋;color:#333333;">&nbsp; &nbsp; 钟湾村两委会特意为全村妇女们精心策划了&ldquo;比比谁的眼力好&rdquo;、&ldquo;赶&lsquo;猪&rsquo;跑&rdquo;、&ldquo;打保龄球&rdquo;、&ldquo;套圈&rdquo;四项游戏活动，让大家动一动、跳一跳、乐一乐，并为每名妇女准备了一份礼品，全村妇女们都踊跃参加到活动中，在这个美丽的季节，大家展示了积极向上、美丽健康的精神风貌，收获了健康和快乐的好心情!</span></p>

<p style=\'margin:0cm;margin-bottom:.0001pt;text-align:justify;font-size:14px;font-family:"Calibri","sans-serif";\'><span style="font-family:仿宋;"><img border="0" src="http://www.jszzwc.com/storage/froala/nNzAz191GUriMwaUpGH4QTXFbxhPaRWmYNfSMHCq.jpeg" alt="IMG_6901.JPG" class="fr-fic fr-dii" style="width: 800px;"><img border="0" src="http://www.jszzwc.com/storage/froala/vomwmUyYaippW3RAxWQAOIaxzJMdqF1pnC9TxDY3.jpeg" alt="IMG_6927.JPG" class="fr-fic fr-dii" style="width: 800px;"></span></p>

<p style=\'margin:0cm;margin-bottom:.0001pt;text-align:justify;font-size:14px;font-family:"Calibri","sans-serif";\'><span style="font-family:仿宋;"><img border="0" src="http://www.jszzwc.com/storage/froala/8gvl8dznRZLNt51YIQCMIB6vG0dfXvQNp4KwiR4d.jpeg" alt="IMG_6871.JPG" class="fr-fic fr-dii" style="width: 800px;"><img border="0" src="http://www.jszzwc.com/storage/froala/S2VXjLnsTb3Ay5uo7qTydDi8ZjdzZ0VXBsn8Cy7Y.jpeg" alt="IMG_6883.JPG" class="fr-fic fr-dii" style="width: 800px;"></span></p>

<p style=\'margin:0cm;margin-bottom:.0001pt;text-align:justify;font-size:14px;font-family:"Calibri","sans-serif";\'><span style="font-family:仿宋;"><img border="0" src="http://www.jszzwc.com/storage/froala/x51p4brrvGEY0tEO6eys27MWU8FDRi4Y1plHQgYX.jpeg" alt="IMG_6891.JPG" class="fr-fic fr-dii" style="width: 800px;"><img border="0" src="http://www.jszzwc.com/storage/froala/j2QZ1akc67p2JOqlmIEYCeu4Wmek1y9mYJzXSWfa.jpeg" alt="IMG_6906.JPG" class="fr-fic fr-dii" style="width: 800px;"></span></p>

<p style=\'margin:0cm;margin-bottom:.0001pt;text-align:justify;font-size:14px;font-family:"Calibri","sans-serif";\'><span style="font-family:仿宋;"><img border="0" src="http://www.jszzwc.com/storage/froala/kUrE80HErEoEl3rXhcD8fsLE9yRhqDrutEL5r8zh.jpeg" class="fr-fic fr-dii" style="width: 800px;"><img border="0" src="http://www.jszzwc.com/storage/froala/NQy4Ku6ei2exLzUn3g1qmJ0OtwklCsft1FMyiFBZ.jpeg" class="fr-fic fr-dii" style="width: 800px;"></span></p>
',
            'thumb_media_id' => $request->input('thumb_media_id'),
            'source_url' => 'http://www.jszzwc.com/activity/168',
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
