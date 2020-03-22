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

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['isLogin']],function() {
    Route::get('index','LoginController@index');
    Route::get('welcome','LoginController@welcome');
    Route::get('logout','LoginController@logout');
});
