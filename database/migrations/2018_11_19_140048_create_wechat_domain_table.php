<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatDomainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_domain', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wechat_id')->nullable()->comment('关联wechat.id');
            $table->string('domain', 100)->nullable()->comment('域名');
            $table->string('path')->nullable()->comment('加载静态文件路径');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `wechat_domain` comment '保存子域名信息'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_domain');
    }
}
