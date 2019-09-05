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
 * 客户管理验证
 */
class Customer extends Base{

    protected $rule = array(
        'name'   => 'require',
        'tel'   => 'require',
        'lianxiren'   => 'require',
        'xukezheng'   => 'require',
    );

    protected $message = array(
        'name.require'   => '客户姓名不能为空',
        'tel.require'   => '联系电话不能为空',
        'lianxiren.require'   => '联系人不能为空',
        'xukezheng.require'   => '经营许可证号',
    );

    protected $scene = array(
        'add'   => 'name,tel,lianxiren,xukezheng',
        'edit'   => 'name,tel,lianxiren,xukezheng'
    );
}