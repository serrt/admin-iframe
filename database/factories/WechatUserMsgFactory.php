<?php

use Faker\Generator as Faker;

$factory->define(App\Models\WechatUserMsg::class, function (Faker $faker) {
    $user = \App\Models\WechatUser::inRandomOrder()->first();
    $time = date('Y-m-d H:i:s');
    return [
        'role_id' => $user->role_id,
        'wechat_id' => $user->wechat_id,
        'user_id' => $user->id,
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'province' => '重庆',
        'city' => '重庆市',
        'area' => '南岸区',
        'remarks' => $faker->sentence,
        'created_at' => $time,
        'updated_at' => $time
    ];
});
