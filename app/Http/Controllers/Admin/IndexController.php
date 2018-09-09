<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Http\Controllers\Controller;
use App\Models\Wechat;
use App\Models\WechatUser;
use App\Models\WechatUserMsg;

class IndexController extends Controller
{
    /**
     * 后台主页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        // 初始化菜单
        $menus = [];
        $list = auth()->user()->permissions();
        foreach ($list->where('pid', 0)->sortBy('sort')->all() as $item) {
            $menu = $this->getMenu($list, $item);
            array_push($menus, $menu);
        }
        $menus = json_encode($menus, JSON_UNESCAPED_UNICODE);
        \Debugbar::disable();
        return view('admin.index', compact('menus', 'user'));
    }

    protected function getMenu($list, Permission $item)
    {
        $menu = [
            'id' => $item->id,
            'text' => $item->name,
            'icon' => $item->key?:'fa fa-list',
        ];
        if (!$item->url) {
            $children = [];
            foreach ($list->where('pid', $item->id)->sortBy('sort')->all() as $item1) {
                $children_menu = $this->getMenu($list, $item1);
                array_push($children, $children_menu);
            }
            $menu['children'] = $children;
        } else {
            $menu['url'] = $item->url;
            $menu['urlType'] = 'absolute';
            $menu['targetType'] = 'iframe-tab';
        }

        return $menu;
    }

    public function home()
    {
        $user = auth('admin')->user();
        $wechat_count = Wechat::query()->when(!$user->isAdmin(), function ($query) use ($user) {
            $query->whereIn('role_id', $user->roles->pluck('id'));
        })->count();

        $user_count = WechatUser::query()->when(!$user->isAdmin(), function ($query) use ($user) {
            $query->whereIn('role_id', $user->roles->pluck('id'));
        })->count();

        $message_count = WechatUserMsg::query()->when(!$user->isAdmin(), function ($query) use ($user) {
            $query->whereIn('role_id', $user->roles->pluck('id'));
        })->count();

        return view('admin.index.home', compact('wechat_count', 'user_count', 'message_count'));
    }
}
