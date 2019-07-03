<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/28
 * Time: 10:05
 */

namespace app\api\model;


use think\Model;

class BannerItem extends BaseModel
{
    protected $hidden = ['id','img_id','banner_id','delete_time','update_time'];

    public function img() {
        return $this->belongsTo('Image','img_id','id');
    }
}