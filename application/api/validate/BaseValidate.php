<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/25
 * Time: 16:50
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck() {
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if(!$result) {
            $e = new ParameterException([
                'msg' => $this->error
            ]);
            throw $e;
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '') {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value, $rule = '' , $data = '', $field = '') {
        if(empty($value)) {
            return false;
        } else {
            return true;
        }
    }

    protected function isMobile($value, $rule = '' , $data = '', $field = '') {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}^';
        $result = preg_match($rule, $value);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getDataByRule($arrays) {
        if(array_key_exists('user_id', $arrays) || array_key_exists('uid', $arrays)) {
            throw new ParameterException([
                'msg' => '参数中包含非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}