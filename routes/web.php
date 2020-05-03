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

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::get('login','LoginController@login');
    Route::post('dologin','LoginController@doLogin');
    Route::get('code','LoginController@code');
});
Route::get('noaccess','Admin\LoginController@noaccess');
//Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['hasRole','isLogin']],function() {
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['isLogin']],function() {
    Route::get('index','LoginController@index');
    Route::get('welcome','LoginController@welcome');
    Route::get('logout','LoginController@logout');
//    删除所有选中用户路由
    Route::get('user/delAll','UserController@delAll');
    Route::resource('user','UserController');
    Route::resource('role','RoleController');
    Route::resource('permission','PermissionController');
    Route::get('role/auth/{id}','RoleController@auth');
    Route::get('user/auth/{id}','UserController@auth');
    Route::post('role/doauth','RoleController@doAuth');
    Route::post('user/doauth','UserController@doAuth');

    //分类路由
    //修改排序
    Route::post('cate/changeorder','CateController@changeOrder');
    Route::resource('cate','CateController');
    Route::resource('article','ArticleController');
    Route::post('article/upload','ArticleController@upload');
});

