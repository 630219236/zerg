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

class Banner extends BaseModel
{
    protected $hidden = ['delete_time','update_time'];
    public function items() {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerById($id) {
        $banner = self::with(['items','items.img'])->find($id);
        return $banner;
    }
}