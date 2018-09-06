<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Wechat::class, function (Faker $faker) {
    $role = \App\Models\Role::inRandomOrder()->first();
    $time = date('Y-m-d H:i:s');
    return [
        'role_id' => $role->id,
        'type' => $faker->numberBetween(0, 1),
        'logo' => 'https://colorhub.me/imgsrv/rQaTxiBLE3WkbspaL29CLW',
        'redirect_url' => $faker->url,
        'name' => $faker->word,
        'app_id' => uniqid(),
        'app_secret' => Hash::make(uniqid()),
        'scope' => $faker->numberBetween(0, 1),
        'created_at' => $time,
        'updated_at' => $time
    ];
});
