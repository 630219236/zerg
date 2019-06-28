<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/25
 * Time: 17:57
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model
{
    public static function getBannerById($id) {
        $result = Db::query('select * from banner_item where banner_id=?',[$id]);
        return $result;
    }
}