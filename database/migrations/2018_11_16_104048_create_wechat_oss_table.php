<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatOssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_oss', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wechat_id')->nullable()->comment('关联wechat.id');
            $table->string('access_key')->nullable();
            $table->string('access_secret')->nullable();
            $table->string('bucket')->nullable();
            $table->string('endpoint')->nullable();
            $table->integer('ssl')->default(0)->comment('是否使用 https');
            $table->integer('isCName')->default(0)->comment('是否使用 自定义域名');
            $table->string('cdnDomain')->comment('自定义域名');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_oss');
    }
}
