<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->nullable()->comment('关联role.id');
            $table->integer('type')->default(0)->nullable()->comment('类型: 0公众号, 1小程序');
            $table->string('app_id')->nullable()->comment('');
            $table->string('app_secret')->nullable()->comment('');
            $table->integer('scope')->default(0)->comment('网页授权: 0静默授权, 1非静默授权');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `wechat` comment '微信APP'");

        Schema::create('wechat_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->nullable()->comment('关联role.id');
            $table->integer('wechat_id')->nullable()->comment('关联wechat.id');
            $table->string('openid')->nullable();
            $table->string('nickname', 100)->nullable();
            $table->integer('sex')->default(1)->nullable();
            $table->string('headimgurl')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `wechat_users` comment '微信用户'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_users');
    }
}
