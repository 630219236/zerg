<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/28
 * Time: 11:41
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['delete_time','create_time','update_time','pivot','from','category_id','category_id','img_id'];

    // 商品图片的URL获取器
    public function getMainImgUrlAttr($value, $data) {
        return $this->prefixImgUrl($value, $data);
    }


    public static function getMostRecent($count) {
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }


    public static function getProductsByCategoryID($categoryID) {
        $products = self::where('category_id', '=', $categoryID)->select();
        return $products;
    }

}