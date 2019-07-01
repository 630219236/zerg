<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/7/1
 * Time: 15:39
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;
}