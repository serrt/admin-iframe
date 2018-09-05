<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminUser::query()->with('roles');

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($query) use ($name) {
                $query->where('name', 'like', '%'.$name.'%');
                $query->orWhere('username', 'like', '%'.$name.'%');
            });
        }

        $role = null;
        if ($request->filled('role')) {
            $role_id = $request->input('role');
            $role = Role::find($role_id);
            $query->whereHas('roles', function ($query) use ($role_id) {
                $query->where('role_id', $role_id);
            });
        }

        $list = $query->paginate();

        return view('admin.user.index', compact('list', 'role'));
    }

    public function create()
    {
        $roles = Role::get();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admin_users,username',
            'password' => 'required'
        ]);

        $user = new AdminUser();
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $user->roles()->attach($request->input('roles'));

        return redirect(route('admin.user.index'))->with('flash_message', '添加成功');
    }

    public function edit($id)
    {
        $user = AdminUser::with('roles')->findOrFail($id);
        $roles = Role::get();

        return view('admin.user.edit', compact('roles', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => ['required', Rule::unique('admin_users', 'username')->ignore($id, 'id')],
        ]);
        $user = AdminUser::findOrFail($id);
        $user->username = $request->input('username');
        $user->name = $request->input('name');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        $user->roles()->detach();
        $user->roles()->attach($request->input('roles'));

        return redirect(route('admin.user.index'))->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $user = AdminUser::findOrFail($id);

        $user->roles()->detach();

        $user->delete();

        return redirect(route('admin.user.index'))->with('flash_message', '删除成功');
    }

    public function checkAdmin(Request $request)
    {
        $unique_rule = Rule::unique('admin_users', 'username');
        if ($request->filled('ignore')) {
            $unique_rule->ignore($request->input('ignore'), 'id');
        }
        $validate = Validator::make($request->all(), [
            'username' => ['required', $unique_rule]
        ]);

        $exists = $validate->fails();

        return $this->json([], $exists?Response::HTTP_BAD_REQUEST:Response::HTTP_OK, $exists?$validate->errors('username')->first():'');
    }
}
