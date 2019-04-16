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

//Route::get('hello/:name', 'index/hello');

//Route::get('user', 'index/user/index');
//Route::get('admin','admin/index/index');
Route::rule('admin$','admin/index/index');
Route::rule('admin/login','admin/index/login');
//Route::rule('admin/login','admin/admin/login');
Route::rule('[:p]$','index/index/index');


