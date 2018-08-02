<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $menus = [
            ['id' => 1, 'text' => '首页', 'icon' => 'fa fa-laptop', 'url' => 'admin/home', 'urlType' => 'absolute', 'targetType' => 'iframe-tab'],
        ];
        $menus = json_encode($menus, JSON_UNESCAPED_UNICODE);
        return view('admin.index', compact('menus'));
    }
    
    public function home()
    {
        return view('admin.index.home');
    }

    public function login()
    {
        return view('admin.login');
    }
}
