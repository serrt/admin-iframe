<?php

use Illuminate\Database\Seeder;

class WechatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = factory(\App\Models\Wechat::class, 20)->make();
        $data = $result->toArray();
        $time = date('Y-m-d H:i:s');
        array_unshift($data, [
            'role_id' => 0,
            'type' => 0,
            'name' => '培迪科技',
            'logo' => 'https://colorhub.me/imgsrv/rQaTxiBLE3WkbspaL29CLW',
            'redirect_url' => 'https://www.baidu.com',
            'app_id' => 'wx58692e1ab1b2f7e5',
            'app_secret' => 'a2f460b01d918a7072559a3648482536',
            'scope' => 1,
            'created_at' => $time,
            'updated_at' => $time
        ]);
        DB::table('wechat')->insert($data);
    }
}
