<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WechatUserResource;
use App\Models\WechatOrder;
use GuzzleHttp\Client;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use OSS\Core\OssException;

class WechatUserController extends Controller
{
    public function __construct()
    {
        \Debugbar::disable();
    }

    /**
     * 获取当前用户信息
     *
     * @param Request $request ['upload_avatar_oss' => '头像上传oss', 'update_avatar_oss' => '头像重新上传oss']
     * @return WechatUserResource|\Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $wechat_user = auth('wechat')->user();
        if ($request->input('upload_avatar_oss')) {
            if (!$wechat_user->avatar_oss || $request->input('update_avatar_oss')) {

                $storage = $wechat_user->wechat->getStorage();

                // 先获取文件, 保存到本地, 再上传到 文件驱动
                $client = new Client(['verify' => false]);
                $save_path = storage_path('app/public/dump');
                $client->get($wechat_user->headimgurl, ['save_to' => $save_path]);

                $wechat_user->avatar_oss = $storage->url($storage->putFile('avatar', new File($save_path)));
                $wechat_user->save();
            }
        }

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

        $validator = Validator::make($request->all(), [
            'data' => 'required',
            'iv' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        // 解密
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

    public function pay(Request $request)
    {
        $request->validate([
            'money' => 'nullable|integer|min:1',
        ], [
            'money.integer' => '订单金额格式不对',
            'money.min' => '订单金额最小值为 1'
        ]);

        $user = auth('wechat')->user();

        $wechat = $user->wechat;

        $app = $wechat->getPayment();

        if (!$app) {
            return $this->error('未配置商户号');
        }

        $out_trade_no = date('YmdHis');
        $money = $request->input('money', 1);
        $type = $request->input('type', 'micro_pay');
        $body = $request->input('body', '订单号: ' . $out_trade_no);
        $openid = $user->openid;

        $ar = [
            'micro_pay' => WechatOrder::TYPE_MICRO,
            'JSAPI' => WechatOrder::TYPE_JS,
            'NATIVE' => WechatOrder::TYPE_NATIVE,
            'APP' => WechatOrder::TYPE_APP,
            'MWEB' => WechatOrder::TYPE_H5,
        ];

        $order = new WechatOrder([
            'out_trade_no' => $out_trade_no,
            'money' => $money,
            'body' => $body,
            'user_id' => $user->id,
            'wechat_id' => $user->wechat_id,
            'pay_id' => $wechat->pay->id,
            'type' => data_get($ar, $type),
        ]);

        // 刷卡支付
        if ($type == 'micro_pay') {
            $auth_code = $request->input('code');
            if (!$auth_code) {
                return $this->error('授权码 code 必填');
            }

            $result = $app->pay([
                'body' => $body,
                'out_trade_no' => $out_trade_no,
                'total_fee' => $money,
                'auth_code' => $auth_code,
            ]);

            logger($result);

            $format = formatResult($result);

            if ($format !== true) {
                return $this->error($format);
            }

            $order->save();

            return $this->json($result);
        }

        // 微信网页版(JSAPI), 小程序支付(JSAPI), 扫码支付(NATIVE), APP支付(APP), H5支付(MWEB)
        $result = $app->order->unify([
            'body' => $body,
            'out_trade_no' => $out_trade_no,
            'total_fee' => $money,
            'trade_type' => $type,
            'openid' => $openid,
        ]);

        $format = formatResult($result);
        if ($format !== true) {
            return $this->error($format);
        }

        // 扫码支付(NATIVE)
        if ($type == 'NATIVE') {
            $order->save();
            return $this->json($result);
        }

        $prepay_id = data_get($result, 'prepay_id');
        if (!$prepay_id) {
            return $this->error('系统错误, 请稍后再试');
        }

        $config = $app->jssdk->sdkConfig($prepay_id);

        $order->save();

        return $this->json($config);
    }
}
