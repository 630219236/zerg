<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/25
 * Time: 17:53
 */

namespace app\lib\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception
{
    public $code = 400;
    public $msg = "参数错误";
    public $errorCode = 10000;

    // 构造函数
    public function __construct($params = []) {
        if(!is_array($params)) {
            return;
        }
        if(array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }

        if(array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }

        if(array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}