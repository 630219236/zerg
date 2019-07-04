<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');

Route::group('api/:version/theme', function () {
    Route::get('', 'api/:version.Theme/getSimpleList');
    Route::get('/:id', 'api/:version.Theme/getComplexOne');
});

Route::group('api/:version/product', function () {
    Route::get('/recent', 'api/:version.Product/getRecent');
    Route::get('/all/by_category', 'api/:version.Product/getAllInCategory');
    Route::get('/:id', 'api/:version.Product/getOne',[],['id' => '\d+']);
});

Route::get('api/:version/category/all', 'api/:version.Category/getCategories');


Route::group('api/:version/token', function () {
    Route::post('/user', 'api/:version.Token/getToken');
    Route::post('/verify', 'api/:version.Token/verifyToken');
});

Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');


Route::group('api/:version/order', function () {
    Route::post('', 'api/:version.Order/placeOrder');
    Route::get('/by_user', 'api/:version.Order/getSummaryByUser');
    Route::get('/:id', 'api/:version.Order/getDetail',[],['id' => '\d+']);
});


Route::group('api/:version/pay', function () {
    Route::post('/pre_order', 'api/:version.Pay/getPreOrder');
    Route::post('/notify', 'api/:version.Pay/receiveNotify');
});




