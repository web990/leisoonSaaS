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
 * 电子运单
 */
class Order extends Base{

    protected $rule = array(
        'title'   => 'require',
    );

    protected $message = array(
        'title.require'   => '标题不能为空',
    );

    protected $scene = array(
        'add'   => 'title',
        'edit'   => 'title'
    );
}