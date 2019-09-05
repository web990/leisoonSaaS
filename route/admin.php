<?php

use think\facade\Route;


Route::group('admin',function (){
    Route::get('auth/<c>/<a>','admin/auth.<c>/<a>');
    Route::get('system/<c>/<a>','admin/system.<c>/<a>');
});

Route::group('aaa',function (){
    Route::get('auth/test999','admin/auth.Roles/test999');
    Route::get('<c>/<a>','admin/<c>/<a>');
} )
    ->header('Access-Control-Allow-Headers','access_token,Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With')
   ->header('Access-Control-Allow-Origin','*')
   ->header('Access-Control-Allow-Methods','POST,PUT,GET,DELETE')
    ->allowCrossDomain();
