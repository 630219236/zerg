<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/30
 * Time: 17:04
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class User
{
    public function getToken($code) {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token' => $token
        ];
    }
}