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
 * 电子运单，线路优化
 */
class OrderXianlu extends Base{

    protected $rule = array(
        'name'   => 'require',
        'qidian'   => 'require',
    );

    protected $message = array(
        'name.require'   => '名称不能为空',
        'qidian.require'   => '起点不能为空',
    );

    protected $scene = array(
        'add'   => 'qidian',
        'edit'   => ''
    );
}