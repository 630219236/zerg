<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/1
 * Time: 1:06
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['user_id', 'id', 'delete_time'];

}