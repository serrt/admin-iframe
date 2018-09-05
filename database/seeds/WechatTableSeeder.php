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
        DB::table('wechat')->insert($result->toArray());
    }
}
