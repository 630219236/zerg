<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/28
 * Time: 10:31
 */

namespace app\api\model;


class Image extends BaseModel
{
    protected $hidden = ['delete_time','update_time','id','from'];


    /**
     * 模型读取器
     */
    public function getUrlAttr($value, $data) {
        return $this->prefixImgUrl($value, $data);
    }

}