<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\KeywordsTypeResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\RoleResource;
use App\Models\KeywordsType;
use App\Models\Permission;
use App\Models\Region;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Storage;

class WebController extends Controller
{
    public function upload(Request $request)
    {
        $files = $request->file();
        $path = $request->input('path', 'uploads/'.date('Y-m-d'));
        $result = [];
        foreach ($files as $key => $fileData) {
            $item = null;
            if (is_array($fileData)) {
                foreach ($fileData as $file) {
                    $savePath = $file->store($path);
                    $item[] = Storage::url($savePath);
                }
            } else {
                $savePath = $fileData->store($path);
                $item = Storage::url($savePath);
            }
            $result[$key] = $item;
        }
        return $this->json($result);
    }

    public function city(Request $request)
    {
        $query = Region::with('parent');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $list = $query->paginate();
        return RegionResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function permission(Request $request)
    {
        $query = Permission::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $list = $query->paginate();

        return PermissionResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function role(Request $request)
    {
        $query = Role::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $list = $query->paginate();

        return RoleResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function keywordsType(Request $request)
    {
        $query = KeywordsType::query();

        if ($request->filled('key')) {
            $name = $request->input('key');
            $query->where(function ($query) use ($name) {
                $query->where('name', 'like', '%'.$name.'%');
                $query->orWhere('key', 'like', '%'.$name.'%');
            });
        }

        $list = $query->paginate();

        return KeywordsTypeResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }
}
