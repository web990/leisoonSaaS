<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/12/17 15:41
 */

use think\facade\Route;

//版本控制
Route::get('api/:version/:controller/:function','api/:version.:controller/:function');