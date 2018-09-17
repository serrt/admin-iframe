<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WechatUserMsgExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function map($row): array
    {
        $sex = '未知';
        $user = $row->user;
        if ($user->sex == 1) {
            $sex = '男';
        } elseif ($user->sex == 2) {
            $sex = '女';
        }
        return [$row->id, $row->wechat->name, $user->openid, $user->nickname, $sex, $user->headimgurl, $row->wx_id, $row->name, $row->phone, $row->address, $row->province.'-'.$row->city.'-'.$row->area, $row->data, $row->remarks, $row->created_at];
    }

    public function headings(): array
    {
        return ['id', '公众号', 'openid', '昵称', '性别', '头像', '微信号', '姓名', '电话', '地址', '地区', '其他', '备注', '录入时间'];
    }
}
