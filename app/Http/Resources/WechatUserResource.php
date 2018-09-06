<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class WechatUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'openid' => $this->openid,
            'nickname' => $this->nickname,
            'sex' => $this->sex,
            'headimgurl' => $this->headimgurl,
        ];
    }

    public function additional(array $data)
    {
        return ['code' => Response::HTTP_OK, 'message' => ''];
    }
}
