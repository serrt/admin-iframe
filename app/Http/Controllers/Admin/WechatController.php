<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\WechatResource;
use App\Models\Role;
use App\Models\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class WechatController extends Controller
{
    public function index(Request $request)
    {
        $query = Wechat::query()
            ->with('role')
            ->withCount(['users', 'messages', 'orders'])
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
            $role = Role::find($role_id);
            $query->where('role_id', $role_id);
        }
        $type = $request->input('type', 'all');
        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $list = $query->paginate();

        return view('admin.wechat.index', compact('list', 'role', 'is_admin', 'type'));
    }

    public function create()
    {
        $user = auth('admin')->user();
        return view('admin.wechat.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'app_id' => 'required',
            'app_secret' => 'required',
            'role_id' => 'required'
        ]);

        $wechat = new Wechat($request->all());
        $wechat->redirect_url = route('wechat.redirect');
        $wechat->save();

        return redirect(route('admin.wechat.index'))->with('flash_message', '添加成功');
    }

    public function show($id)
    {
        $info = Wechat::query()->withCount(['users', 'orders'])->with(['role', 'pay'])->findOrFail($id);
        return view('admin.wechat.show', compact('info'));
    }

    public function edit($id)
    {
        $info = Wechat::findOrFail($id);

        return view('admin.wechat.edit', compact('info'));
    }

    public function update(Request $request, $id)
    {
        $wechat = Wechat::findOrFail($id);
        $request->validate([
            'app_id' => 'required',
            'app_secret' => 'required'
        ]);

        $user = auth('admin')->user();
        if (!$user->isAdmin() && !$user->hasRole($wechat->role_id)) {
            return back()->withErrors(['没有权限修改']);
        }

        $wechat->update($request->all());

        return redirect(route('admin.wechat.index'))->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $wechat = Wechat::findOrFail($id);
        $user = auth('admin')->user();
        if (!$user->isAdmin() && !$user->hasRole($wechat->role_id)) {
            return back()->withErrors(['没有权限删除']);
        }
        // 删除OSS记录
        $wechat->oss()->delete();
        // 删除订单
        $wechat->orders()->delete();
        // 删除用户留资
        $wechat->messages()->delete();
        // 删除用户记录
        $wechat->users()->delete();
        // 删除APP
        $wechat->delete();

        return back()->with('flash_message', '删除成功');
    }

    public function search(Request $request)
    {
        $query = Wechat::query()->orderBy('created_at', 'desc');

        $user = auth('admin')->user();
        $is_admin = $user->isAdmin();

        if (!$is_admin) {
            $query->whereIn('role_id', $user->roles->pluck('id'));
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $list = $query->paginate();

        return WechatResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function oss(Wechat $wechat, Request $request)
    {
        $data = $request->only(['access_key', 'access_secret', 'bucket', 'endpoint', 'cdnDomain']);
        $data['ssl'] = $request->input('ssl', 0);
        $data['isCName'] = $request->input('cdnDomain', '')?1:0;
        $wechat->oss()->updateOrCreate([], $data);
        return back()->with('flash_message', '修改成功');
    }

    public function pay(Wechat $wechat, Request $request)
    {
        $data = $request->only(['mch_id', 'key', 'cert_path', 'key_path', 'notify_url']);
        $wechat->pay()->updateOrCreate([], $data);
        return back()->with('flash_message', '修改成功');
    }
}
