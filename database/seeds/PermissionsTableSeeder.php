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
            ['id' => 2, 'name' => '表格', 'pid' => 0, 'key' => 'fa fa-table', 'url' => 'admin/table', 'sort' => 2],
            ['id' => 3, 'name' => '表单', 'pid' => 0, 'key' => 'fa fa-edit', 'url' => null, 'sort' => 3],
            ['id' => 4, 'name' => '系统', 'pid' => 0, 'key' => 'fa fa-gear', 'url' => null, 'sort' => 4],
            ['id' => 5, 'name' => '网站', 'pid' => 0, 'key' => 'fa fa-globe', 'url' => null, 'sort' => 5],

            ['id' => 6, 'name' => '基本表单', 'pid' => 3, 'key' => 'fa fa-newspaper-o', 'url' => 'admin/form', 'sort' => 1],
            ['id' => 7, 'name' => 'ajax', 'pid' => 3, 'key' => 'fa fa-pencil-square', 'url' => 'admin/ajax', 'sort' => 2],

            ['id' => 8, 'name' => '菜单', 'pid' => 4, 'key' => 'fa fa-list', 'url' => 'admin/permission', 'sort' => 1],
            ['id' => 9, 'name' => '角色', 'pid' => 4, 'key' => 'fa fa-user-secret', 'url' => 'admin/role', 'sort' => 2],
            ['id' => 10, 'name' => '用户管理', 'pid' => 4, 'key' => 'fa fa-users', 'url' => 'admin/user', 'sort' => 3],

            ['id' => 11, 'name' => '字典类型', 'pid' => 5, 'key' => 'fa fa-key', 'url' => 'admin/keywords_type', 'sort' => 1],
            ['id' => 12, 'name' => '字典', 'pid' => 5, 'key' => 'fa fa-key', 'url' => 'admin/keywords', 'sort' => 2],

        ]);
    }
}
