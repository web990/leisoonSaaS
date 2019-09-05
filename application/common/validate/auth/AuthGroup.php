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
 * 权限组
 */
class AuthGroup extends Base {

    protected $rule = array(
        'name'   => 'require',
        'description'   => 'require',
    );

    protected $message = array(
        'name'   => '角色名名不能为空',
        'description'   => '描述不能为空',
    );

    protected $scene = array(
        'add'   => 'name',
        'edit'   => 'name,description'
    );
}