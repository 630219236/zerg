<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/1
 * Time: 18:20
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder($id = '') {
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }


    public function receiveNotify()
    {
        // 1、检测库存量，超卖
        // 2、更新订单的状态
        // 3、减少商品库存

        //特点：1、post  2、xml格式  3、不携带参数
        $notify = new WxNotify();
        $notify->Handle();
    }

}