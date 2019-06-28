<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/25
 * Time: 14:56
 */

namespace app\api\controller\v1;


use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner
{
    public function getBanner($id) {
        (new IDMustBePositiveInt())->goCheck();
        $banner = BannerModel::get($id);
        if(!$banner) {
            throw new BannerMissException();
        }
        return $banner;
    }
}