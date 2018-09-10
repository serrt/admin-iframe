<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\WechatUserResource;
use App\Models\Role;
use App\Models\Wechat;
use App\Models\WechatUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class WechatUsersController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->getQuery($request)
            ->with('wechat')
            ->withCount('messages')
            ->with('role');

        $user = auth('admin')->user();
        $is_admin = $user->isAdmin();

        $role = null;
        if ($request->filled('role')) {
            $role_id = $request->input('role');
            $role = Role::find($role_id);
        }

        $wechat = null;
        if ($request->filled('wechat')) {
            $wechat_id = $request->input('wechat');
            $wechat = Wechat::find($wechat_id);
        }

        $list = $query->paginate();

        return view('admin.wechat_users.index', compact('list', 'is_admin', 'role', 'wechat'));
    }

    public function search(Request $request)
    {
        $query = $this->getQuery($request);

        $list = $query->paginate();

        return WechatUserResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    protected function getQuery(Request $request)
    {
        $query = WechatUser::query()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');

        $user = auth('admin')->user();
        $is_admin = $user->isAdmin();

        if (!$is_admin) {
            $query->whereIn('role_id', $user->roles->pluck('id'));
        }

        $role = null;
        if ($request->filled('role')) {
            $role_id = $request->input('role');
            $query->where('role_id', $role_id);
        }

        $wechat = null;
        if ($request->filled('wechat')) {
            $wechat_id = $request->input('wechat');
            $query->where('wechat_id', $wechat_id);
        }

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where('nickname', 'like' ,'%'.$name.'%');
        }

        return $query;
    }
}
