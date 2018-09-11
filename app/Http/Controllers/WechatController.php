<?php

namespace App\Http\Controllers;

use App\Http\Resources\WechatUserResource;
use App\Models\Wechat;
use App\Models\WechatUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use EasyWeChat\Factory;
use Overtrue\Socialite\User as SocialiteUser;

class WechatController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');

        abort_if(!$id, Response::HTTP_BAD_REQUEST, 'id 参数必填');

        $wechat = $this->getWechat($id);

        $app = $this->getApp($wechat);
        // 微信公众号
        if ($wechat->type == Wechat::TYPE_MP) {

            $scope = $request->input('scope', $wechat->scope);
            $scopes = [Wechat::SCOPE_BASE => 'snsapi_base', Wechat::SCOPE_USERINFO => 'snsapi_userinfo'];

            $redirectUrl = $wechat->redirect_url.'?id='.$wechat->id;
            $response = $app->oauth->scopes([$scopes[$scope]])->redirect($redirectUrl);

            if ($request->filled('success_url')) {
                $wechat->success_url = $request->filled('success_url');
                $wechat->save();
            }

            if (config('app.debug')) {
                return redirect(route('wechat.redirect', ['id'=>$wechat->id]));
            }

            return $response;
        }
        // 微信小程序
        else if ($wechat->type == Wechat::TYPE_MIN){
            $code = $request->input('code');
            abort_if(!$code, Response::HTTP_BAD_REQUEST, 'code 参数必填');
            try {
                return $app->auth->session($code);
            } catch (\EasyWeChat\Kernel\Exceptions\InvalidConfigException $e) {
                return $this->error($e->getMessage());
            }

        }
        return $this->error('未知的公众号类型');
    }

    public function redirect(Request $request)
    {
        $app_id = $request->input('id');

        abort_if(!$app_id, Response::HTTP_BAD_REQUEST, 'id 参数必填');

        $wechat = $this->getWechat($app_id);

        $app = $this->getApp($wechat);

        if (config('app.debug')) {
            $user = new SocialiteUser([
                'id' => 'ozhmz0y3cPXLoWwq20uPTbKb84xg',
                'name' => '潘亮',
                'nickname' => '潘亮',
                'avatar' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/yYucjbJeBiaiaCn0txK5BER4v3jtXB8Vn3fsM46RqQadgDrtkHEeWnur6glxdFQ2cXDSm6kunjJE1dbqhFtiafbOw/132',
                'email' => null,
                'original' => [
                    "openid" => "ozhmz0y3cPXLoWwq20uPTbKb84xg",
                    "nickname" => "潘亮",
                    "sex" => 1,
                    "language" => "zh_CN",
                    "city" => "南岸",
                    "province" => "重庆",
                    "country" => "中国",
                    "headimgurl" => "http://thirdwx.qlogo.cn/mmopen/vi_32/yYucjbJeBiaiaCn0txK5BER4v3jtXB8Vn3fsM46RqQadgDrtkHEeWnur6glxdFQ2cXDSm6kunjJE1dbqhFtiafbOw/132",
                    "privilege" => [],
                ],
                'provider' => 'WeChat',
            ]);
        } else {
            $user = $app->oauth->user();
        }
        $user_origin = $user->getOriginal();

        $where = [
            'role_id' => $wechat->role_id,
            'wechat_id' => $wechat->id,
            'openid' => $user->getId(),
        ];
        WechatUser::query()->updateOrCreate($where, [
            'nickname' => $user->getName(),
            'headimgurl' => $user->getAvatar(),
            'sex' => isset($user_origin['sex'])?$user_origin['sex']:0,
        ]);

        $wechat_user = WechatUser::where($where)->first();

        $stub = str_contains($wechat->success_url, '?')?'&':'?';
        $url = $wechat->success_url.$stub.'token='.$wechat_user->api_token.'&token_type=Bearer';
        return redirect($url);
    }

    public function auth()
    {
        $wechat_user = auth('wechat')->user();

        return WechatUserResource::make($wechat_user);
    }

    protected function getWechat($id)
    {
        $wechat = Wechat::find($id);

        abort_if(!$wechat, Response::HTTP_BAD_REQUEST, $id.' 公众号尚未在后台添加');

        return $wechat;
    }

    protected function getApp(Wechat $wechat)
    {
        $config = [
            'app_id' => $wechat->app_id,
            'secret' => $wechat->app_secret,

            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];
        if ($wechat->type == Wechat::TYPE_MP) {
            $app = Factory::officialAccount($config);
        }
        else if ($wechat->type == Wechat::TYPE_MIN){
            $app = Factory::miniProgram($config);
        }
        return $app;
    }
}
