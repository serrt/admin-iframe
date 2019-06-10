<?php

namespace App\Http\Controllers;

use App\Models\Wechat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Overtrue\LaravelWeChat\Facade as EasyWechat;

class MpController extends Controller
{
    public function index()
    {
        return view('mp.index');
    }

    public function image(Request $request)
    {
        if ($request->has('id')) {
            $wechat = $this->getWechat($request->input('id', 1));
            $app = $this->getApp($wechat);
        } else {
            $app = EasyWeChat::officialAccount();
        }
//        $origin = $request->header('origin');
//        $referer = $request->header('Referer');
//
//        if (empty($origin)) {
//            return response()->json(['msg' => '授权地址出错', 'code' => 501], 200);
//        }
//
//        $app->jssdk->setUrl($referer);
        return view('mp.image', compact('app'));
    }

    protected function getWechat($id)
    {
        $wechat = Wechat::find($id);

        abort_if(!$wechat, Response::HTTP_BAD_REQUEST, $id.' 公众号尚未在后台添加');

        return $wechat;
    }
}
