<?php

namespace App\Http\Controllers\Api;

use App\Services\Face;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FaceController extends Controller
{
    public function detect(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $result = Face::init()->detect($request->file);

        if (isset($result['faces']) && !empty($result['faces'])) {
            return $this->success($result['faces']);
        }

        return $this->error('未识别到人脸');
    }

    public function merge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template' => 'required',
            'merge' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $result = Face::init()->mergeface($request->template, $request->merge, $request->input('template_detect'));

        if (isset($result['result']) && $result['result']) {
//            return response(base64_decode($result['result']), 200, ['Content-Type' => 'image/png']);
            $path = 'face/'.uniqid().'.jpg';
            $storage = Storage::disk('public');
            $storage->put($path, base64_decode($result['result']));

            $url = $storage->url($path);
            return $this->json(['url' => $url]);
        }
        return $this->error('合成失败');
    }
}
