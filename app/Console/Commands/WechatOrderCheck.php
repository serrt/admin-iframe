<?php

namespace App\Console\Commands;

use App\Models\WechatOrder;
use Carbon\Carbon;
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
    protected $description = '查询微信支付的订单, --out_trade_no: 微信商户订单号';

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
        if ($out_trade_no) {
            $order = WechatOrder::where('out_trade_no', $out_trade_no)->first();
            if (!$order) {
                $this->error('订单号 '.$out_trade_no.' 不存在');
                exit;
            }

            $this->handleOrder($order);
        } else {
            // 遍历所有 未支付 的订单
            $list = WechatOrder::where('status', WechatOrder::STATUS_PROCESS)->with(['wechat'])->get();
            foreach ($list as $item) {
                $this->handleOrder($item);
            }
        }
    }

    protected function handleOrder(WechatOrder $order)
    {
        $wechat = $order->wechat;
        $payment = $wechat->getPayment();

        $result = $payment->order->queryByOutTradeNumber($order->out_trade_no);

        $this->info(json_encode($result, true));

        if ($order->status == WechatOrder::STATUS_PROCESS && data_get($result, 'trade_state') == 'SUCCESS') {
            $order->status = WechatOrder::STATUS_SUCCESS;
            $order->success_time = Carbon::createFromFormat('YmdHis', data_get($result, 'time_end'));
            $order->save();
        }
    }
}