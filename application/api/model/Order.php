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

    public function getSnapItemsAttr($value) {
        if(!$value) {
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value) {
        if(!$value) {
            return null;
        }
        return json_decode($value);
    }

    public static function getSummaryByUser($uid, $page=1, $size=15) {
        $pagingData = self::where('user_id', '=', $uid)->order('create_time', 'desc')
            ->paginate($size, false, ['page' => $page]);
        return $pagingData;
    }
}