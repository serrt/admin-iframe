<?php

namespace App\Console\Commands;

use App\Models\WechatOrder;
use Illuminate\Console\Command;

class WechatOrderCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:order-check {--out_trade_no=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '查询微信支付的订单, --order: 查询单个订单号状态';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $out_trade_no = $this->option('out_trade_no');
        $order = WechatOrder::where('out_trade_no', $out_trade_no)->first();
        if (!$order) {
            $this->error('订单号 '.$out_trade_no.' 不存在');
        }

        $wechat = $order->wechat;
        $payment = $wechat->getPayment();

        $result = $payment->order->queryByOutTradeNumber($order->out_trade_no);

        $this->info($result);

        if ($order->status == WechatOrder::STATUS_PROCESS && data_get($result, 'trade_state', 'SUCCESS')) {
            $order->status = WechatOrder::STATUS_PROCESS;
            $order->success_time = now();
            $order->save();
        }
    }
}
