<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/1
 * Time: 11:05
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
    public function checkPrimaryScope() {
        TokenService::needPrimaryScope();
    }

    public function checkExclusiveScope() {
        TokenService::needExclusiveScope();
    }

}