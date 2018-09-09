<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Wechat;
use App\Models\WechatUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatUsersController extends Controller
{
    public function index(Request $request)
    {
        $query = WechatUser::query()
            ->with('wechat')
            ->with('role')
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

        $wechat = null;
        if ($request->filled('wechat')) {
            $wechat_id = $request->input('wechat');
            $wechat = Wechat::find($wechat_id);
            $query->where('wechat_id', $wechat_id);
        }

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where('nickname', 'like' ,'%'.$name.'%');
        }

        $list = $query->paginate();

        return view('admin.wechat_users.index', compact('list', 'is_admin', 'role', 'wechat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
