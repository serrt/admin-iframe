<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['id' => 1, 'name' => '首页', 'pid' => 0, 'key' => 'fa fa-home', 'url' => 'admin/home', 'sort' => 1],
            ['id' => 2, 'name' => '表格', 'pid' => 0, 'key' => 'fa fa-table', 'url' => 'admin/home', 'sort' => 2],
            ['id' => 3, 'name' => '表单', 'pid' => 0, 'key' => 'fa fa-edit', 'url' => null, 'sort' => 3],
            ['id' => 4, 'name' => '权限', 'pid' => 0, 'key' => 'fa fa-coffee', 'url' => null, 'sort' => 4],

            ['id' => 4, 'name' => '基本表单', 'pid' => 3, 'key' => 'fa fa-edge', 'url' => 'admin/form', 'sort' => 1],
            ['id' => 5, 'name' => 'ajax', 'pid' => 3, 'key' => 'fa fa-edge', 'url' => 'admin/ajax', 'sort' => 2],
            ['id' => 7, 'name' => '菜单', 'pid' => 4, 'key' => 'fa fa-list', 'url' => 'admin/permission', 'sort' => 1],
        ]);
    }
}
