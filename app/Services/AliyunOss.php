<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use OSS\OssClient;
use OSS\Core\OssException;

/**
 * 阿里云-OSS
 * [文档](https://help.aliyun.com/product/31815.html)
 */
class AliyunOss
{
    protected $accessKeyId;
    protected $accessKeySecret;
    // 访问域名, https://help.aliyun.com/document_detail/31837.html
    protected $endpoint;
    // 存储空间
    protected $bucket;
    // 回源域名
    protected $back_url;

    public function __construct($key = '', $secret = '', $endpoint = '', $bucket = '', $back_url = '')
    {
        $config = config('filesystems.disks.oss');

        $this->accessKeyId = $key?:$config['access_id'];
        $this->accessKeySecret = $secret?:$config['access_key'];
        $this->endpoint = $endpoint?:$config['endpoint'];
        $this->bucket = $bucket?:$config['bucket'];
        $this->back_url = $back_url?:$config['back_url'];
    }

    public static function init($key = '', $secret = '', $endpoint = '', $bucket = '', $back_url = '')
    {
        return new AliyunOss($key, $secret, $endpoint, $bucket, $back_url);
    }

    /**
     * 上传本地单个文件
     *
     * @param $file string 文件本地路径 example: /usr/local/a.jpg
     * @param $filename string 保存的文件名和目录 example: head/photo.jpg, 默认为原文件名
     * @param $path string 保存的目录 example: head/user
     * @return string 文件新路径
     */
    public function uploadFile($file, $filename = '', $path = '')
    {
        try{
            if (!$filename) {
                $pathInfo = pathinfo($file);
                $filename = $pathInfo['basename'];
            }
            if ($path) {
                $filename = $path.'/'.$filename;
            }
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            $result = $ossClient->uploadFile($this->bucket, $filename, $file);
            // 外网访问路径
            return $result['oss-request-url'];
        } catch(OssException $e) {
            return $e->getMessage();
        }
    }

    /**
     * 上传远程的单个文件
     *
     * @param $link string 远程路径 example: https://baidu.com/a.jpg
     * @param $filename string 保存的文件名称 example: a.jpg
     * @param string $path 保存的目录 example: head/user
     * @return string 文件新地址
     */
    public function uploadUrl($link, $filename, $path = '')
    {
        // 同时可以考虑使用 $ossClient->putObject 直接写入资源到OSS上, 不过速度太慢了
        // 先本地保存, 再上传
        $client = new Client(['verify' => false]);
        $save_path = storage_path('app/public/dump');
        $client->get($link, ['save_to' => $save_path]);
        if ($path) {
            $filename = $path.'/'.$filename;
        }
        $url = $this->uploadFile($save_path, $filename);
        if ($this->back_url) {
            $url = $this->back_url.'/'.$filename;
        }
        return $url;
    }
}