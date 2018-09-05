<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatUserMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_user_msg', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->nullable()->comment('关联role.id');
            $table->integer('wechat_id')->nullable()->comment('关联wechat.id');
            $table->integer('user_id')->nullable()->comment('关联wechat_users.id');
            $table->string('name')->nullable()->comment('姓名');
            $table->string('phone', 20)->nullable()->comment('电话');
            $table->string('address')->nullable()->comment('地址');
            $table->string('province', 50)->nullable()->comment('省级');
            $table->string('city', 50)->nullable()->comment('市级');
            $table->string('area', 50)->nullable()->comment('区级');
            $table->string('remarks')->nullable()->comment('备注');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `wechat_user_msg` comment '微信留信息'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_user_msg');
    }
}
