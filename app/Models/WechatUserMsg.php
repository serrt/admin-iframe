<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatUserMsg extends Model
{
    protected $table = 'wechat_user_msg';

    protected $fillable = ['id', 'role_id', 'wechat_id', 'user_id', 'wx_id', 'name', 'phone', 'address', 'province', 'city', 'area', 'remarks', 'file', 'data', 'created_at', 'updated_at'];

    public function wechat()
    {
        return $this->hasOne(Wechat::class, 'id', 'wechat_id');
    }

    public function user()
    {
        return $this->hasOne(WechatUser::class, 'id', 'user_id');
    }

    public function setFileAttribute($file = null)
    {
        $storage = $this->wechat->getStorage();

        $path = 'file/'.date('Y-m-d');
        if (is_array($file)) {
            $data = [];
            foreach ($file as $key => $value) {
                if (gettype($value) == 'object') {
                    $data[] = $storage->putFile($path, $value);
                } else if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $value, $result)) {
                    $type = $result[2];
                    if(in_array($type,array('jpeg','jpg','gif','bmp','png'))) {
                        $savePath = $path . '/' . uniqid() . '.' . $type;
                        $storage->put($savePath, base64_decode(str_replace($result[1], '', $value)));
                        $data[] = $savePath;
                    }
                }
            }
            $this->attributes['file'] = implode(',', $data);
        } else {
            if (gettype($file) == 'object') {
                $file = $storage->putFile($path, $file);
            } else if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $file, $result)) {
                $type = $result[2];
                if(in_array($type,array('jpeg','jpg','gif','bmp','png'))) {
                    $savePath = $path . '/' . uniqid() . '.' . $type;
                    $storage->put($savePath, base64_decode(str_replace($result[1], '', $file)));
                    $file = $savePath;
                }
            }
            $this->attributes['file'] = $file;
        }
    }

    public function getFileAttribute($value)
    {
        $storage = $this->wechat->getStorage();
        if (str_contains($value, ',')) {
            $result = [];
            foreach (explode(',', $value) as $key => $file) {
                $result[] = preg_match('/^https?:\/\//i', $file) === 0 ? $storage->url($file) : $file;
            }
            return implode(',', $result);
        } else if ($value && preg_match('/^https?:\/\//i', $value) === 0){
            return $storage->url($value);
        }
        return $value;
    }
}
