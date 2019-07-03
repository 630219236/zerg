<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/25
 * Time: 16:39
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id' => 'id必须是正整数'
    ];
}