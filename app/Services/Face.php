<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * 旷视人脸
 *
 * https://www.faceplusplus.com.cn
 *
 * @package App\Services
 */
class Face
{
    protected $api_key;

    protected $api_secret;

    public function __construct($api_key = '', $api_secret = '')
    {
        $this->api_key = $api_key?:env('FACE_API_KEY', 'lZnP5mvTFiTOvZR1F1N50yPYITpqPs6s');
        $this->api_secret = $api_secret?:env('FACE_API_SECRET', 'nuQzND40WFuWjEUUoSVhnPsu0UAlcpR4');
    }

    public function detect($file)
    {
        $options = [];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $file, $result)) {
            $type = $result[2];
            if(in_array($type,array('jpeg','jpg','gif','bmp','png'))) {
                $content = str_replace($result[1], '', $file);
                $options = [
                    'form_params' => [
                        'api_key' => $this->api_key,
                        'api_secret' => $this->api_secret,
                        'image_base64' => $content,
                    ],
                ];
            }
        }  else if (gettype($file) == 'object') {
            $options = [
                'multipart' => [
                    ['name' => 'api_key', 'contents' => $this->api_key],
                    ['name' => 'api_secret', 'contents' => $this->api_secret],
                    ['name' => 'image_file', 'contents' => fopen($file->path(), 'r')]
                ]
            ];
        } else {
            $options = [
                'form_params' => [
                    'api_key' => $this->api_key,
                    'api_secret' => $this->api_secret,
                    'image_url' => $file,
                ],
            ];
        }

        try {
            $result = json_decode($this->client()->post('facepp/v3/detect', $options)->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $result = ['error' => $e->getMessage()];
        }

        return $result;
    }

    public function mergeface($template, $merge, $template_detect = [])
    {
        $options = [];

        if (!$template_detect) {
            $template_detect = $this->detect($template);
            if (!isset($template_detect['faces']) || empty($template_detect['faces'])) {
                return ['error' => '模板文件未识别到人脸'];
            }
            $rectangle = $template_detect['faces'][0]['face_rectangle'];
        } else {
            $rectangle = json_decode($template_detect, true)['face_rectangle'];
        }

        $template_rectangle = implode(',', [$rectangle['top'], $rectangle['left'], $rectangle['width'], $rectangle['height']]);


        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $template, $result)) {
            $type = $result[2];
            if(in_array($type,array('jpeg','jpg','gif','bmp','png'))) {
                $content = str_replace($result[1], '', $template);
                $options = [
                    'form_params' => [
                        'api_key' => $this->api_key,
                        'api_secret' => $this->api_secret,
                        'template_base64' => $content,
                        'template_rectangle' => $template_rectangle,
                        'merge_base64' => $merge,
                    ],
                ];
            }
        } else if (gettype($template) == 'object') {
            $options = [
                'multipart' => [
                    ['name' => 'api_key', 'contents' => $this->api_key],
                    ['name' => 'api_secret', 'contents' => $this->api_secret],
                    ['name' => 'template_file', 'contents' => fopen($template->path(), 'r')],
                    ['name' => 'template_rectangle', 'contents' => $template_rectangle],
                    ['name' => 'merge_file', 'contents' => fopen($merge->path(), 'r')],
                ]
            ];
        } else {
            $options = [
                'form_params' => [
                    'api_key' => $this->api_key,
                    'api_secret' => $this->api_secret,
                    'template_url' => $template,
                    'template_rectangle' => $template_rectangle,
                    'merge_url' => $merge,
                ],
            ];
        }

        try {
            $result = json_decode($this->client()->post('imagepp/v1/mergeface', $options)->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $result = ['error' => $e->getMessage()];
        }

        return $result;
    }

    public static function init($api_key = '', $api_secret = '')
    {
        return new Face($api_key, $api_secret);
    }


    protected function client()
    {
        $client = new Client(['base_uri' => 'https://api-cn.faceplusplus.com/']);

        return $client;
    }
}
