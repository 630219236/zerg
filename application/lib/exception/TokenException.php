<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/30
 * Time: 19:28
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;
}