<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // 初始化菜单
        $menus = [
            ['id' => 1, 'text' => '首页', 'icon' => 'fa fa-laptop', 'url' => 'admin/home', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
            ['id' => 2, 'text' => '表格', 'icon' => 'fa fa-table', 'url' => 'admin/table', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
            ['id' => 3, 'text' => '表单', 'icon' => 'fa fa-edit', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
        ];
        $menus = json_encode($menus, JSON_UNESCAPED_UNICODE);
        \Debugbar::disable();
        return view('admin.index', compact('menus'));
    }

    public function home()
    {
        return view('admin.index.home');
    }

    public function table(Request $request)
    {
        $query = Region::query()->with('parent');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('pid')) {
            $query->where('pid', $request->input('pid'));
        }

        $list = $query->paginate();
        return view('admin.index.table', compact('list'));
    }

    public function form()
    {
        return view('admin.index.form');
    }

    public function login()
    {
        return view('admin.login');
    }
}
