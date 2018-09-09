<?php

use Faker\Generator as Faker;

$factory->define(App\Models\WechatUser::class, function (Faker $faker) {
    $wechat = \App\Models\Wechat::inRandomOrder()->first();
    $time = date('Y-m-d H:i:s');
    return [
        'role_id' => $wechat->role_id,
        'wechat_id' => $wechat->id,
        'openid' => uniqid(),
        'nickname' => $faker->name,
        'sex' => $faker->numberBetween(0, 2),
        'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/yYucjbJeBiaiaCn0txK5BER4v3jtXB8Vn3fsM46RqQadgDrtkHEeWnur6glxdFQ2cXDSm6kunjJE1dbqhFtiafbOw/132',
        'api_token' => \App\Models\WechatUser::getToken(),
        'created_at' => $time,
        'updated_at' => $time
    ];
});
