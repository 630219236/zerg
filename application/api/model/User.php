<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/30
 * Time: 17:20
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address() {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByOpenID($openID) {
        $user = self::where('openid', '=', $openID)->find();
        return $user;
    }

}