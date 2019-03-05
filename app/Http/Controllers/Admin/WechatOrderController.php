<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\WechatResource;
use App\Http\Resources\WechatUserResource;
use App\Models\Wechat;
use App\Models\WechatOrder;
use App\Models\WechatUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = WechatOrder::query()
            ->with(['wechat', 'user'])
            ->orderBy('created_at', 'desc');

        $auth_user = auth('admin')->user();
        $is_admin = $auth_user->isAdmin();
        if (!$is_admin) {
            $role_ids = $auth_user->roles->pluck('id');
            $query->whereHas('wechat', function ($q) use ($role_ids) {
                $q->whereIn('role_id', $role_ids);
            });
        }

        $wechat = null;
        if ($request->filled('wechat_id')) {
            $wechat_id = $request->input('wechat_id');
            $query->where('wechat_id', $wechat_id);
            $wechat = WechatResource::make(Wechat::findOrFail($wechat_id));
        }

        $user = null;
        if ($request->filled('user_id')) {
            $user_id = $request->input('user_id');
            $query->where('user_id', $user_id);
            $user = WechatUserResource::make(WechatUser::findOrFail($user_id));
        }

        if ($request->filled('start_time')) {
            $query->where('created_at', '>=', $request->input('start_time'));
        }

        if ($request->filled('end_time')) {
            $query->where('created_at', '<=', $request->input('end_time'));
        }

        $list = $query->paginate();

        return view('admin.wechat_order.index', compact('list', 'wechat', 'user'));
    }

    public function show($id)
    {
        $info = WechatOrder::with(['user', 'wechat'])->findOrFail($id);

        $wechat = $info->wechat;

        $user = $info->user;

        return view('admin.wechat_order.show', compact('info', 'wechat', 'user'));
    }
}
