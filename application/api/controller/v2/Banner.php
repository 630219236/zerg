<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/28
 * Time: 11:14
 */

namespace app\api\controller\v2;


class Banner
{
    public function getBanner($id){
        return 'This is v2 version '.$id;
    }
}