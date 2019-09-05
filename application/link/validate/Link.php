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
        'title'   => 'require',
    );

    protected $message = array(
        'title.require'   => '字段标题不能为空！',
    );

    protected $scene = array(
        'add'   => 'title',
        'edit'   => 'title'
    );

}