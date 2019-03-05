<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatPayTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_pay', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wechat_id')->comment('关联wechat.id');
            $table->string('mch_id')->comment('微信商户id');
            $table->string('key')->comment('微信api秘钥');
            $table->string('cert_path')->nullable()->comment('证书cert绝对地址');
            $table->string('key_path')->nullable()->comment('证书key绝对地址');
            $table->string('notify_url')->nullable()->comment('回调地址, 完整的路径');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `wechat_pay` comment '保存微信支付信息'");

        Schema::create('wechat_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('关联wechat_user.id');
            $table->integer('wechat_id')->comment('关联wechat.id');
            $table->integer('pay_id')->comment('关联wechat_pay.id');
            $table->string('out_trade_no')->comment('订单流水号');
            $table->string('body')->nullable()->comment('订单备注');
            $table->string('type', 20)->nullable()->comment('支付方式(micro_pay: 付款码, js_api: 微信网页, min_program: 小程序支付, native: 扫码支付, app: APP支付, h5: H5支付)');
            $table->integer('money')->nullable()->comment('支付金额(单位: 分)');
            $table->integer('status')->default(1)->comment('订单状态(-1: 支付失败, 1: 待支付, 2: 已支付, 3: 取消支付)');
            $table->timestamp('success_time')->nullable()->comment('成功支付时间');
            $table->timestamp('cancel_time')->nullable()->comment('取消支付时间');
            $table->string('remarks')->nullable()->comment('系统备注');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `wechat_orders` comment '保存微信支付的订单信息'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_pay');
        Schema::dropIfExists('wechat_orders');
    }
}
