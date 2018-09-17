<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WechatUsersExport implements FromQuery, WithHeadings, WithMapping
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
        if ($row->sex == 1) {
            $sex = '男';
        } elseif ($row->sex == 2) {
            $sex = '女';
        }
        return [$row->id, $row->role?$row->role->name:'', $row->wechat->name, $row->openid, $row->nickname, $sex, $row->headimgurl, $row->created_at, $row->messages_count];
    }

    public function headings(): array
    {
        return ['id', '角色', '公众号', 'openid', '昵称', '性别', '头像', '注册时间', '填写资料数'];
    }
}
