<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{
    public function index()
    {
        $list = Permission::get();

        return view('admin.permission.index', compact('list'));
    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'display_name' => 'required'
        ],[
            'name.required' => 'key 值必填',
            'name.unique' => 'key 值 :input 已经存在'
        ]);

        Permission::create($request->all());

        return redirect(route('admin.permission.index'));
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $unique_rule = Rule::unique('permissions', 'name')->ignore($permission->id, 'id');

        $request->validate([
            'name' => ['required', $unique_rule],
            'display_name' => 'required'
        ],[
            'name.required' => 'key 值必填',
            'name.unique' => 'key 值 :input 已经存在'
        ]);


        $permission->update($request->all());

        return redirect(route('admin.permission.index'))->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        // 删除关联的 role_permissions
        \DB::table('role_permissions')->where('permission_id', $permission->id)->delete();

        // 删除所有子集
        $permission->children()->delete();

        $permission->delete();

        return redirect(route('admin.permission.index'))->with('flash_message', '删除成功');
    }
}
