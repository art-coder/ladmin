<?php

use Illuminate\Support\Facades\Route;

// Route::get('demo', function () {
//     return view('admin::welcome');
// });


// // $environment = \App::environment();
// // if ($environment == 'local') {
// //     $middleware = ['web', 'wechat.simulate.oauth', 'wechat.oauth.sync'];
// // } else {
// //     $middleware = ['web', 'wechat.oauth', 'wechat.oauth.sync'];
// // }

// Route::prefix('core')->group(function() {
//     Route::get('/', 'CoreController@index');
// });

// admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web', 'admin']], function () {
    // home index
    Route::get('/', 'IndexController@index')->name('home.index');// 后台首页
    Route::get('/test', 'IndexController@index')->name('test.index');// 测试页面

    Route::get('setting/index', 'IndexController@setting')->name('setting.index'); // 网站基本配置
    Route::post('setting/index', 'IndexController@save')->name('setting.index'); // 网站基本配置存储
    Route::get('setting/create', 'IndexController@create')->name('setting.create'); // 添加网站基本配置
    Route::post('setting/create', 'IndexController@saveSingle')->name('setting.create'); // 存储网站基本配置
    // Route::any('setting/sensitive', 'IndexController@sensitive')->name('setting.sensitive'); // 敏感词
    Route::get('setting/password', 'IndexController@password')->name('setting.password'); // 修改密码
    Route::post('setting/password', 'IndexController@savePassword')->name('setting.password'); // 修改密码
    Route::post('upload', 'IndexController@upload')->name('upload'); // 上传图片

    Route::get('permission/index', 'PermissionController@index')->name('permission.index');
    Route::get('permission/create', 'PermissionController@create')->name('permission.create');
    Route::get('permission/edit/{id}', 'PermissionController@edit')->name('permission.edit');
    Route::post('permission/store', 'PermissionController@store')->name('permission.store');
    Route::get('permission/delete/{id}', 'PermissionController@delete')->name('permission.delete');

    Route::get('role/index', 'RoleController@index')->name('role.index');
    Route::get('role/create', 'RoleController@create')->name('role.create');
    Route::get('role/edit/{id}', 'RoleController@edit')->name('role.edit');
    Route::post('role/store', 'RoleController@store')->name('role.store');
    Route::get('role/delete/{id}', 'RoleController@delete')->name('role.delete');

    Route::get('user/index', 'UserController@index')->name('user.index');
    Route::get('user/create', 'UserController@create')->name('user.create');
    Route::get('user/edit/{id}', 'UserController@edit')->name('user.edit');
    Route::get('user/search', 'UserController@search')->name('user.search');
    Route::post('user/store', 'UserController@store')->name('user.store');
    Route::get('user/delete/{id}', 'UserController@delete')->name('user.delete');

});

// login logout
Route::group(['middleware' => ['web']], function () {
    Route::get('login', 'AccountController@login')->name('login');
    Route::post('login', 'AccountController@loginPost')->name('login.post');
    Route::get('logout', 'AccountController@logout')->name('logout');
    Route::get('register', 'AccountController@register')->name('register');
    Route::post('register', 'AccountController@registerPost')->name('register.post');
});

// admin loin logout
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web']], function () {
    Route::get('login', 'HomeController@login')->name('login');
    Route::post('login', 'HomeController@pl')->name('pl');
    Route::get('logout', 'HomeController@logout')->name('logout');
});
