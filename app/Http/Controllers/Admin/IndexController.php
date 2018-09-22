<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
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
        $user = auth()->user();
        // 初始化菜单
        $menus = [];
        $list = $user->menus;

        foreach ($list->where('pid', 0)->sortBy('sort')->all() as $item) {
            $menu = $this->getMenu($list, $item);
            array_push($menus, $menu);
        }
        \Debugbar::disable();
//        return view('admin.spa', compact('menus', 'user'));
        return view('admin.iframe', compact('menus', 'user'));
    }

    protected function getMenu($list, Menu $item)
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
            $url = $item->url;
            if (str_contains($url, '.')) {
                $url = route($url);
            } else {
                $url = url($url);
            }
            $menu['url'] = $url;
            $menu['urlType'] = 'absolute';
            $menu['targetType'] = 'iframe-tab';
        }

        return $menu;
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

        $region = null;
        if ($request->filled('pid')) {
            $pid = $request->input('pid');
            $region = Region::find($pid);
            $query->where('pid', $pid);
        }

        $list = $query->paginate();
        return view('admin.index.table', compact('list', 'region'));
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
