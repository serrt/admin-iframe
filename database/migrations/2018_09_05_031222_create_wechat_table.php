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
            $table->string('name', 100)->nullable()->comment('名称');
            $table->string('logo')->nullable()->comment('logo图片');
            $table->string('app_id')->nullable();
            $table->string('app_secret')->nullable();
            $table->string('redirect_url')->nullable()->comment('在微信平台上配置的回跳地址');
            $table->string('success_url')->nullable()->comment('授权成功后的地址');
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
            $table->integer('sex')->default(0)->nullable()->comment('用户的性别，值为1时是男性，值为2时是女性，值为0时是未知');
            $table->string('headimgurl')->nullable();
            $table->string('api_token', 100)->nullable()->comment('auth-token');
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
        Schema::dropIfExists('wechat');
        Schema::dropIfExists('wechat_users');
    }
}
