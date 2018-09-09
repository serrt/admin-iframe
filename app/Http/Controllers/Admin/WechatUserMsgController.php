<?php

namespace App\Http\Controllers\Admin;

use App\Models\Wechat;
use App\Models\WechatUserMsg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatUserMsgController extends Controller
{
    public function index(Request $request)
    {
        $query = WechatUserMsg::query()
            ->with('wechat')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');

        $user = auth('admin')->user();
        $is_admin = $user->isAdmin();
        if (!$is_admin) {
            $query->whereIn('role_id', $user->roles->pluck('id'));
        }

        $wechat = null;
        if ($request->filled('wechat')) {
            $wechat_id = $request->input('wechat');
            $wechat = Wechat::find($wechat_id);
            $query->where('wechat_id', $wechat_id);
        }

        $list = $query->paginate();

        return view('admin.wechat_user_msg.index', compact('list', 'wechat'));
    }

    public function show($id)
    {
        $info = WechatUserMsg::with('wechat')->with('user')->findOrFail($id);

        return view('admin.wechat_user_msg.show', compact('info'));
    }
}
