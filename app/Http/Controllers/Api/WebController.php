<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\AdminUser;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Storage;

class WebController extends Controller
{
    public function upload(Request $request)
    {
        $path = $request->input('path', 'uploads/'.date('Y-m-d'));
        $result = [];

        // file 文件
        $files = $request->file();
        foreach ($files as $key => $fileData) {
            $item = null;
            if (is_array($fileData)) {
                foreach ($fileData as $file) {
                    $item[] = Storage::url($this->saveFile($path, $file));
                }
            } else {
                $item = Storage::url($this->saveFile($path, $fileData));
            }
            $result[$key] = $item;
        }

        // base64 图片
        $data = $request->post();
        foreach ($data as $key => $files) {
            $item = null;
            if (is_array($files)) {
                foreach ($files as $file) {
                    $item[] = Storage::url($this->saveFile($path, $file));
                }
            } else {
                $item = Storage::url($this->saveFile($path, $files));
            }
            $result[$key] = $item;
        }
        return $this->json($result);
    }

    protected function saveFile($path, $file = null)
    {
        if (gettype($file) == 'object') {
            logger($file->getSize());
            $file = Storage::putFile($path, $file);
        } else if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $file, $result)) {
            $type = $result[2];
            if(in_array($type,array('jpeg','jpg','gif','bmp','png'))) {
                $savePath = $path . '/' . uniqid() . '.' . $type;
                Storage::put($savePath, base64_decode(str_replace($result[1], '', $file)));
                $file = $savePath;
            }
        }
        return $file;
    }

    public function permission(Request $request)
    {
        $query = Permission::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('pid')) {
            $query->where('pid',  $request->input('pid'));
        }

        $list = $query->paginate();

        return PermissionResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function role(Request $request)
    {
        $query = Role::query();

        if ($request->filled('user_id')) {
            $user = AdminUser::find($request->input('user_id'));
            $query = $user->roles();
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $list = $query->paginate();

        return RoleResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function fileRemove(Request $request)
    {
        return $this->json($request->all());
    }
}
