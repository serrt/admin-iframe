<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'text' => $this->name,
            'pid' => $this->pid,
            'key' => $this->key,
            'url' => $this->url,
            'sort' => $this->sort
        ];
        return $data;
    }
}
