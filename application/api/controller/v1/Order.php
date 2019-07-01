<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/1
 * Time: 10:40
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    // 提交订单流程：
    // 提交下单数据至API接口
    // 库存检测（有数据：添加数据至订单表，下单成功，返回客户端，允许下单）
    // 调用支付接口，进行支付
    // 还需要进行库存检测
    // 服务器这边可以调用微信的支付接口进行支付
    // 微信返回一个支付结果
    // 支付成功：再一次进行库存量的检测
    // 支付成功：扣除库存量。  支付失败：返回一个支付失败的结果。

    protected $beforeActionList = [
        'needExclusiveScope' => ['only' => 'placeOrder']
    ];

    public function placeOrder() {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }
}