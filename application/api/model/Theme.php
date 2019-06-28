<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/28
 * Time: 11:42
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['head_img_id','topic_img_id', 'delete_time', 'update_time'];

    public function topicImg() {
        return $this->belongsTo('Image','topic_img_id', 'id');
    }

    public function headImg() {
        return $this->belongsTo('Image','head_img_id','id');
    }

    public function products() {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }

    public static function getThemeWithProducts($id) {
        $theme = self::with(['topicImg','headImg', 'products'])->find($id);
        return $theme;
    }

}