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
 * 设置模型
 */
class Type extends Base{

    protected $rule = array(
        'title'   => 'require',
    );

    protected $message = array(
        'title.require'   => '名称不能为空！',
    );

    protected $scene = array(
        'add'   => 'title',
        'edit'   => 'title'
    );
}