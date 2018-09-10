<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [1 => '活动一', 2 => '活动二', 3 => '活动三', 4=>'活动四'];
        $permission_ids = [1,2,5,6,7,8,9];
        $role_data = [];
        $role_permissions = [];
        foreach ($roles as $key => $value) {
            array_push($role_data, ['name' => $value]);
            foreach ($permission_ids as $pid) {
                array_push($role_permissions, ['role_id' => $key, 'permission_id' => $pid]);
            }
        }
        DB::table('roles')->insert($role_data);
        DB::table('role_permissions')->insert($role_permissions);
    }
}
