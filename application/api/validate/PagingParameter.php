<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/3
 * Time: 10:07
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger',
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数',
    ];

}