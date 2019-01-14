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
            // return response(base64_decode($result['result']), 200, ['Content-Type' => 'image/png']);
            // $path = 'face/'.uniqid().'.png';
            // $storage = Storage::disk('public');
            // $storage->put($path, base64_decode($result['result']));

            // $url = $storage->url($path);
            // return $this->json(['url' => $url]);
            // $data = 'data:image/png;base64,'.base64_decode($result['result']);
            $data = $result['result'];
            return $this->json($data);
        }
        return $this->error(data_get($result, 'error', '合成失败'));
    }

    public function multipleMerge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template' => 'required',
            'merge' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $template_array = is_array($request->template)?$request->template:[$request->template];
        $merge_array = is_array($request->merge)?$request->merge:[$request->merge];
        $template_detect_array = is_array($request->template_detect)?$request->template_detect:[$request->template_detect];
        $data = [];

        set_time_limit(0);
        foreach ($template_array as $key => $template) {
            foreach ($merge_array as $merge) {
                $template_detect = [];
                if (isset($template_detect_array[$key])) {
                    $template_detect = $template_detect[$key];
                }
                $result = Face::init()->mergeface($template, $merge, $template_detect);
                // if (isset($result['result']) && $result['result']) {
                //     $path = 'face/'.uniqid().'.jpg';
                //     $storage = Storage::disk('public');
                //     $storage->put($path, base64_decode($result['result']));

                //     $url = $storage->url($path);
                // }
                // $url = 'data:image/png;base64,'.base64_decode($result['result']);
                $url = $result['result'];
                array_push($data, $url);
            }
        }

        return $this->json($data);
    }
}
