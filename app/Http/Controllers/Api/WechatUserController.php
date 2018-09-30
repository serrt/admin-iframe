<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WechatUserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatUserController extends Controller
{
    public function info()
    {
        $wechat_user = auth('wechat')->user();

        return WechatUserResource::make($wechat_user);
    }
    public function update(Request $request)
    {
        $user = auth('wechat')->user();

        // 解密
        if ($request->has('data')) {
            $session = $user->session_key;
            $iv = $request->input('iv');
            $app = $this->getApp($user->wechat);
            try {
                $decryptedData = $app->encryptor->decryptData($session, $iv, $request->input('data'));
                if (isset($decryptedData['nickName']) && $decryptedData['nickName']) {
                    $user->nickname = $decryptedData['nickName'];
                }
                if (isset($decryptedData['gender']) && $decryptedData['gender']) {
                    $user->sex = $decryptedData['gender'];
                }
                if (isset($decryptedData['avatarUrl']) && $decryptedData['avatarUrl']) {
                    $user->headimgurl = $decryptedData['avatarUrl'];
                }
                if (isset($decryptedData['province']) && $decryptedData['province']) {
                    $user->province = $decryptedData['province'];
                }
                if (isset($decryptedData['city']) && $decryptedData['city']) {
                    $user->city = $decryptedData['city'];
                }
                $user->save();
            } catch (\EasyWeChat\Kernel\Exceptions\DecryptException $e) {
                return $this->error('解析失败, '.$e->getMessage());
            }
        }
        return $this->json(WechatUserResource::make($user));
    }

    public function decrypt(Request $request)
    {
        $user = auth('wechat')->user();

        // 解密
        if ($request->has('data')) {
            $session = $user->session_key;
            $iv = $request->input('iv');
            $app = $this->getApp($user->wechat);
            try {
                $decryptedData = $app->encryptor->decryptData($session, $iv, $request->input('data'));
                return $this->json($decryptedData);
            } catch (\EasyWeChat\Kernel\Exceptions\DecryptException $e) {
                return $this->error('解析失败, '.$e->getMessage());
            }
        }
        return $this->error('data 参数必须');
    }
}
