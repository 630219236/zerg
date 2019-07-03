<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/28
 * Time: 20:52
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;


class Category
{
    public function getCategories(){
        $categories = CategoryModel::all([],'img');
        if($categories->isEmpty()) {
            throw new CategoryException();
        }
        return $categories;
    }
}