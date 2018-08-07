<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class RegionsController extends Controller
{
    public function index(Request $request)
    {
        $query = Region::query()->with('parent');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $list = $query->paginate();
        return RegionResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }
}
