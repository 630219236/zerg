<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/1
 * Time: 18:22
 */

namespace app\api\service;


use app\lib\enmu\OrderStatusEnmu;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use think\Loader;
use think\Log;

// extend/WxPay/WxPay.Api.php
Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
    private $orderID;
    private $orderNo;


    public function __construct($orderID) {
        if(!$orderID) {
            throw new Exception('订单号不允许为空');
        }
        $this->orderID = $orderID;
    }


    public function pay() {
        // 订单号可能不存在
        // 订单号存在，但是订单号和当前用户不匹配
        // 订单有可能被支付过
        // 进行库存检测
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if(!$status['pass']) {
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }


    private function makeWxPreOrder($totalPrice) {
        $openid = Token::getCurrentTokenVar('openid');
        if(!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNo);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));
        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData) {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败','error');
        }
        // 处理prepay_id
        return $wxOrder;
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);

        return $signature;
    }


    private function sign($wxOrder) {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());

        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);

        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;

        unset($rawValues['appId']);

        return $rawValues;
    }


    private function recordPreOrder($wxOrder) {
        OrderModel::where('id', '=', $this->orderID)->update([
            'prepay_id' => $wxOrder['prepay_id']
        ]);
    }


    private function checkOrderValid() {
        $order = OrderModel::where('id', '=', $this->orderID)->find();
        if(!$order) {
            throw new OrderException();
        }
        if(!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
                'msg' => '订单号与用户不匹配',
                'errorCode' => 10003
            ]);
        }
        if($order->status != OrderStatusEnmu::UNPAID) {
            throw new OrderException([
                'msg' => '订单状态异常',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNo = $order->order_no;
        return true;
    }

}