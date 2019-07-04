<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/28
 * Time: 20:53
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'topic_img_id'];

    public function img() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}