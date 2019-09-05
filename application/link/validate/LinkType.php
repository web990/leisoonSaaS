<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\link\validate;

/**
* 验证模型
*/
class Link extends Base{

    protected $rule = array(
        'name'   => 'require',
    );

    protected $message = array(
        'name.require'   => '分类名不能为空！',
    );

    protected $scene = array(
        'add'   => 'name',
        'edit'   => 'name'
    );

}