<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WechatUserMsgResource;
use App\Models\WechatUserMsg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class WechatUserMsgController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('wechat')->user();
        $message = WechatUserMsg::where('user_id', $user->id)->paginate();

        return WechatUserMsgResource::collection($message)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function store(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required',
//            'phone' => 'required',
//            'address' => 'required',
//        ], [
//            'name.required' => '姓名必填',
//            'phone.required' => '电话号码必填',
//            'address.required' => '地址必填'
//        ]);
//
//        if ($validator->fails()) {
//            return $this->error($validator->errors()->first());
//        }

        $user = auth('wechat')->user();

        $message = WechatUserMsg::updateOrCreate([
            'role_id' => $user->role_id,
            'wechat_id' => $user->wechat_id,
            'user_id' => $user->id
        ], $request->all());

        return WechatUserMsgResource::make($message);
    }

    public function storeMultiple(Request $request)
    {
        $user = auth('wechat')->user();
        $data = $request->all();
        $empty = true;
        foreach ($data as $key => $value) {
            if ($value) {
                $empty = false;
            }
        }
        if ($empty) {
            return $this->error('未上传任何数据');
        }
        $message = WechatUserMsg::create(array_merge([
            'role_id' => $user->role_id,
            'wechat_id' => $user->wechat_id,
            'user_id' => $user->id
        ], $data));

        return WechatUserMsgResource::make($message);
    }
}
