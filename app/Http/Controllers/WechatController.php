<?php

namespace App\Http\Controllers;

use App\Http\Resources\WechatUserResource;
use App\Models\Wechat;
use App\Models\WechatUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use EasyWeChat\Factory;

class WechatController extends Controller
{
    public function index(Request $request)
    {
        $app_id = $request->input('app_id');

        abort_if(!$app_id, Response::HTTP_BAD_REQUEST, 'app_id 参数必填');

        $wechat = $this->getWechat($app_id);

        abort_if(!$wechat, Response::HTTP_BAD_REQUEST, $app_id.' 公众号尚未在后台添加');

        $app = $this->getApp($wechat);
        // 微信公众号
        if ($wechat->type == Wechat::TYPE_MP) {

            $scope = $request->input('scope', $wechat->scope);
            $scopes = [Wechat::SCOPE_BASE => 'snsapi_base', Wechat::SCOPE_USERINFO => 'snsapi_userinfo'];

            $redirectUrl = $wechat->redirect_url.'?app_id='.$app_id;
            $response = $app->oauth->scopes([$scopes[$scope]])->redirect($redirectUrl);

            return $response;
        }
        // 微信小程序
        else if ($wechat->type == Wechat::TYPE_MIN){
            $code = $request->input('code');
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
        $app_id = $request->input('app_id');

        abort_if(!$app_id, Response::HTTP_BAD_REQUEST, 'app_id 参数必填');

        $wechat = $this->getWechat($app_id);

        abort_if(!$wechat, Response::HTTP_BAD_REQUEST, $app_id.' 公众号尚未在后台添加');

        $app = $this->getApp($wechat);

        $user = $app->oauth->user();
        $user_origin = $user->getOriginal();

        $wechat_user = new WechatUser();
        $wechat_user->role_id = $wechat->role_id;
        $wechat_user->wechat_id = $wechat->id;
        $wechat_user->openid = $user->getId();
        $wechat_user->nickname = $user->getName();
        $wechat_user->headimgurl = $user->getAvatar();
        $wechat_user->sex = $user_origin['sex'];
        $wechat_user->save();

        return redirect($wechat->success_url);
    }

    public function auth()
    {
        $wechat_user = auth('wechat')->user();

        return WechatUserResource::make($wechat_user);
    }

    protected function getWechat($app_id)
    {
        $wechat = Wechat::where('app_id', $app_id)->first();

        abort_if(!$wechat, Response::HTTP_BAD_REQUEST, $app_id.' 公众号尚未在后台添加');

        return $wechat;
    }

    protected function getApp(Wechat $wechat)
    {
        $config = [
            'app_id' => $wechat->app_id,
            'secret' => $wechat->secret,

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
