<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\validate;

/**
 * 行车费用
 */
class OrderFeiyong extends Base{

    protected $rule = array(
        'name'   => 'require',
        'money'   => 'require',
    );

    protected $message = array(
        'name.require'   => '名称不能为空',
        'money.require'   => '请填写金额',
    );

    protected $scene = array(
        'add'   => 'money',
        'edit'   => ''
    );
}