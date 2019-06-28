<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/28
 * Time: 11:41
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    /**
     * @url: /theme
     * @params: ids
     */
    public function getSimpleList($ids = '') {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with(['topicImg', 'headImg'])->select($ids);
        if($result->isEmpty()) {
            throw new ThemeException();
        }
        return $result;
    }


    /**
     * @url: /theme/:id
     * @params: id
     */
    public function getComplexOne($id) {
        (new IDMustBePositiveInt())->goCheck();
        $result = ThemeModel::getThemeWithProducts($id);
        if(!$result) {
            throw new ThemeException();
        }
        return $result;
    }

}