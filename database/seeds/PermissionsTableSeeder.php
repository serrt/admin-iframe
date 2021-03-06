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
        $menus = [
            ['name' => '首页', 'key' => 'fa fa-home', 'url' => 'admin/home'],
            ['name' => '表格', 'key' => 'fa fa-table', 'url' => 'admin/table'],
            ['name' => '表单', 'key' => 'fa fa-edit', 'url' => null, 'children' => [
                ['name' => '基本表单', 'key' => 'fa fa-newspaper-o', 'url' => 'admin/form'],
                ['name' => 'ajax', 'key' => 'fa fa-pencil-square', 'url' => 'admin/ajax']
            ]],
            ['name' => '系统', 'key' => 'fa fa-gear', 'url' => null, 'children' => [
                ['name' => '菜单', 'key' => 'fa fa-list', 'url' => 'admin/permission'],
                ['name' => '角色', 'key' => 'fa fa-user-secret', 'url' => 'admin/role'],
                ['name' => '用户管理', 'key' => 'fa fa-users', 'url' => 'admin/user']
            ]],
            ['name' => '网站', 'pid' => 0, 'key' => 'fa fa-globe', 'url' => null, 'children' => [
                ['name' => '字典类型', 'key' => 'fa fa-key', 'url' => 'admin/keywords_type'],
                ['name' => '字典', 'key' => 'fa fa-key', 'url' => 'admin/keywords']
            ]],
        ];
        $data = [];
        $index = 1;
        foreach ($menus as $key => $item) {
            $menu = $item;
            $menu['id'] = $index;
            $index++;
            $menu['pid'] = 0;
            $menu['sort'] = $key+1;
            unset($menu['children']);
            array_push($data, $menu);
            if (isset($item['children'])) {
                foreach ($item['children'] as $key1 => $item1) {
                    $menu1 = $item1;
                    $menu1['id'] = $index;
                    $index++;
                    $menu1['pid'] = $menu['id'];
                    $menu1['sort'] = $key1+1;
                    array_push($data, $menu1);
                }
            }
        }
        DB::table('permissions')->delete();
        DB::table('permissions')->insert($data);
    }
}
