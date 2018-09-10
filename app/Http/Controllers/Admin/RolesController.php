<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::query()->withCount('wechats');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }

        $list = $query->paginate();

        return view('admin.role.index', compact('list'));
    }

    public function create()
    {
        $list = Permission::orderBy('sort')->orderBy('id')->get();

        return view('admin.role.create', compact('list'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::create($request->all());

        // 更新权限
        $permissions = $request->input('permissions');
        $role->permissions()->attach($permissions);

        return redirect(route('admin.role.index'))->with('flash_message', '添加成功');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $list = Permission::orderBy('sort')->orderBy('id')->get();
        return view('admin.role.edit', compact('role', 'list'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::findOrFail($id);

        $role->update($request->all());

        // 更新权限
        $permissions = $request->input('permissions');
        $role->permissions()->detach();
        $role->permissions()->attach($permissions);

        return redirect(route('admin.role.index'))->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // 删除关联的 role_permissions
        $role->permissions()->detach();

        $role->delete();

        return redirect(route('admin.role.index'))->with('flash_message', '删除成功');

    }
}
