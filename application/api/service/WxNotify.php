<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/2
 * Time: 20:05
 */

namespace app\api\service;


use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\api\model\Product as ProductModel;
use app\lib\enmu\OrderStatusEnmu;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg) {
        if($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];
            Db::startTrans();
            try {
                $order = OrderModel::where('order_no', '=', $orderNo)->find();
                if($order->status == OrderStatusEnmu::UNPAID) {
                    $service = new OrderService();
                    $stockStatus = $service->checkOrderStock($order->id);
                    if($stockStatus['pass']) {
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($stockStatus);
                    } else {
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();
                return true;
            } catch (Exception $ex) {
                Db::rollback();
                Log::error($ex);
                return false;
            }
        } else {
            return true;
        }
    }


    private function updateOrderStatus($orderID, $success) {
        $status = $success ? OrderStatusEnmu::PAID : OrderStatusEnmu::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)->update(['status', $status]);
    }


    private function reduceStock($stockStatus) {
        foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
            ProductModel::where('id', '=', $singlePStatus['id'])->setDec('stock', $singlePStatus['count']);
        }
    }
}