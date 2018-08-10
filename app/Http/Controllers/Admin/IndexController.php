<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use Illuminate\Http\Request;
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
        // 初始化菜单
        $menus = [
            ['id' => 3, 'text' => '表单', 'icon' => 'fa fa-edit', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
            ['id' => 1, 'text' => '首页', 'icon' => 'fa fa-laptop', 'url' => 'admin/home', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
            ['id' => 2, 'text' => '表格', 'icon' => 'fa fa-table', 'url' => 'admin/table', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
            ['id' => 4, 'text' => '表单4', 'icon' => 'fa fa-edit', 'children' => [
                ['id' => 5, 'text' => '表单5', 'icon' => 'fa fa-edit', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
                ['id' => 6, 'text' => '表单6', 'icon' => 'fa fa-edit', 'children' => [
                    ['id' => 10, 'text' => '表单10', 'icon' => 'fa fa-edit', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
                    ['id' => 11, 'text' => '表单11', 'icon' => 'fa fa-edit', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
                    ['id' => 12, 'text' => '表单12', 'icon' => 'fa fa-edit', 'children' => [
                        ['id' => 13, 'text' => '表单13', 'icon' => 'fa fa-edit', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
                        ['id' => 14, 'text' => '表单14', 'icon' => 'fa fa-edit', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
                    ]],
                ]],
            ]],
            ['id' => 7, 'text' => '表单7', 'icon' => 'fa fa-edit', 'children' => [
                ['id' => 8, 'text' => '表单8', 'icon' => 'fa fa-edit', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
                ['id' => 9, 'text' => '表单9', 'icon' => 'fa fa-edit', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
            ]],
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

    public function formUpload(Request $request)
    {
        $file = $request->file('file');
        if ($file) {
            $file = $file->store('uploads');
            // 获取文件全路径
            $fileUrl = asset($file);
        }

        $files = $request->file('files');
        dump($files);
    }
}
