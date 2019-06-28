<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/28
 * Time: 16:34
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids参数必须是以逗号分隔的整数数组'
    ];

    protected function checkIDs($value) {
        $values = explode(',', $value);

        // 判断是否为空数组
        if(empty($values)) {
            return false;
        }
        // 判断是否为正整数
        foreach ($values as $id) {
            if(!$this->isPositiveInteger($id)) {
                return false;
            }
        }
        return true;
    }


}