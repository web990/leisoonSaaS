<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\validate\auth;

use app\common\validate\Base;

/**
 * 管理员
 */
class Admin extends Base {

    protected $rule = array(
        'username|用户名' =>  'require|unique:admin',
        'nickname|昵称' =>  'require',
        'password|密码' =>  'length:6,20|confirm:repassword',
        'email|Email'  =>  'email',
        'mobile|手机号'  =>  'mobile',
        'idcard|身份证号'  =>  'idCard',
    );

    protected $scene = array(
        'add'   => ['username', 'password','mobile','idcard','email']
        ,'edit'  => ['username', 'password','mobile','idcard','email']
        ,'del'  => ['id']
    );
}