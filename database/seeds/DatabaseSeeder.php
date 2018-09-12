<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(AdminUsersTableSeeder::class);
        $time = date('Y-m-d H:i:s');
        DB::table('wechat')->insert([
            'role_id' => 0,
            'type' => 0,
            'name' => '培迪科技',
            'logo' => 'https://colorhub.me/imgsrv/rQaTxiBLE3WkbspaL29CLW',
            'redirect_url' => 'http://melanin.hmily.club',
            'app_id' => 'wx58692e1ab1b2f7e5',
            'app_secret' => 'a2f460b01d918a7072559a3648482536',
            'scope' => 1,
            'created_at' => $time,
            'updated_at' => $time
        ]);
    }
}
