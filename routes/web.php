<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 后台首页
Route::get('admin/index','Admin\AdminIndexController@index');
Route::get('admin/info','Admin\AdminIndexController@info');

// 物品路由
Route::get('admin/goods/index','Admin\Basics\GoodsController@index');
Route::get('admin/goods/getCount','Admin\Basics\GoodsController@getGoodsCount');
Route::get('admin/goods/getElement','Admin\Basics\GoodsController@getGoodsElement');
Route::get('admin/goods/addGoods','Admin\Basics\GoodsController@addGoods');
Route::get('admin/goods/editGoods','Admin\Basics\GoodsController@editGoods');
Route::post('admin/goods/storeGoods','Admin\Basics\GoodsController@storeGoods');
Route::post('admin/goods/deleteGoods','Admin\Basics\GoodsController@deleteGoods');
Route::get('admin/goods/getList','Admin\Basics\GoodsController@getList');

// 库存路由
Route::get('admin/stock/index','Admin\Stock\StockController@index');
Route::get('admin/stock/getCount','Admin\Stock\StockController@getCount');
Route::get('admin/stock/getElement','Admin\Stock\StockController@getElement');
Route::get('admin/stock/addGoods','Admin\Stock\StockController@addGoods');
Route::post('admin/stock/storeGoods','Admin\Stock\StockController@storeGoods');
Route::get('admin/stock/checkout','Admin\Stock\StockController@checkout');
Route::post('admin/outStock/storeOutStock','Admin\Stock\StockController@storeOutStock');

// 出库入库记录
Route::get('admin/record/index','Admin\Stock\RecordController@index');
Route::get('admin/record/getCount','Admin\Stock\RecordController@getCount');
Route::get('admin/record/getElement','Admin\Stock\RecordController@getElement');
Route::post('admin/record/exportExcel','Admin\Stock\RecordController@exportExcel');
Route::post('admin/record/deleteRecord','Admin\Stock\RecordController@deleteRecord');
