<?php

namespace App\Http\Controllers\Admin;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

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
            ['id' => 1, 'text' => '首页', 'icon' => 'fa fa-laptop', 'url' => 'admin/home', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
            ['id' => 2, 'text' => '表格', 'icon' => 'fa fa-table', 'url' => 'admin/table', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
            ['id' => 3, 'text' => '表单', 'icon' => 'fa fa-edit', 'children' => [
                ['id' => 4, 'text' => '基本表单', 'icon' => 'fa fa-table', 'url' => 'admin/form', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
                ['id' => 5, 'text' => 'ajax', 'icon' => 'fa fa-table', 'url' => 'admin/ajax', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
            ]],
            ['id' => 6, 'text' => '权限', 'icon' => 'fa fa-coffee', 'children' => [
                ['id' => 7, 'text' => '菜单', 'icon' => 'fa fa-list', 'url' => 'admin/permission', 'urlType' =>  'absolute', 'targetType' => 'iframe-tab']
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
        $img_url = 'http://oobpqw2m0.bkt.clouddn.com/xhg-download.png';
        $imgs_url = 'http://oobpqw2m0.bkt.clouddn.com/webwxgetmsgimg.jpg, http://oobpqw2m0.bkt.clouddn.com/xhg-download.png';
        return view('admin.index.form', compact('img_url', 'imgs_url'));
    }

    public function ajax()
    {
        $imgs_url = 'http://oobpqw2m0.bkt.clouddn.com/webwxgetmsgimg.jpg, http://oobpqw2m0.bkt.clouddn.com/xhg-download.png';
        return view('admin.index.ajax', compact('imgs_url'));
    }

    public function formUpload(Request $request)
    {
        // 获取上传的文件
        $file = $request->file('file');
        if ($file) {
            // 保存文件
            $file = $file->store('uploads');
            // 获取文件全路径
            $fileUrl = Storage::url($file);
            dump($fileUrl);
        }
    }
}
