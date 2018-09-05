<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Http\Controllers\Controller;

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
        return view('admin.index.home');
    }
}
