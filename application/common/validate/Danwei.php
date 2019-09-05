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
class Danwei extends Base{

    protected $rule = array(
        'title'   => 'require',
        'name'   => 'require',
    );

    protected $message = array(
        'title.require'   => '单位名称不能为空！',
        'name.require'   => '单位标识不能为空',
    );

    protected $scene = array(
        'add'   => 'title,name',
        'edit'   => 'title,name'
    );
}