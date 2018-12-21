<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WechatUserMsgExport;
use App\Models\Wechat;
use App\Models\WechatUser;
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
        $user = null;
        if ($request->filled('user')) {
            $user_id = $request->input('user');
            $user = WechatUser::find($user_id);
            $query->where('user_id', $user_id);
        }

        if ($request->filled('start_time')) {
            $query->where('created_at', '>=', $request->input('start_time'));
        }

        if ($request->filled('end_time')) {
            $query->where('created_at', '<=', $request->input('end_time'));
        }

        if ($request->has('export')) {
            return (new WechatUserMsgExport($query))->download('用户流资.xlsx');
        }

        $list = $query->paginate();

        return view('admin.wechat_user_msg.index', compact('list', 'wechat', 'user'));
    }

    public function show($id)
    {
        $info = WechatUserMsg::with('wechat')->with('user')->findOrFail($id);

        return view('admin.wechat_user_msg.show', compact('info'));
    }
}
