<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/11/16 11:07
 */

// 中间件扩展定义文件
return [
    //跨域请求
    'cors'  => app\http\middleware\Cors::class

    //获取AccessToken
    ,'AccessToken'  => app\http\middleware\AccessToken::class
];