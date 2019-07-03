<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/2
 * Time: 12:55
 */

namespace app\lib\enmu;


class OrderStatusEnmu
{
    // 待支付
    const UNPAID = 1;

    // 已支付
    const PAID = 2;

    // 已发货
    const DELIVERED = 3;

    // 已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;
}