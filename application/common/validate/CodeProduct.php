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
 * 产品录入
 */
class CodeProduct extends Base
{

    protected $rule = array(
        'code' => 'unique:CodeProduct',
    );

    protected $message = array(
        'code' => '产品已录入',
    );

    protected $scene = array(
        'add' => '',
        'edit' => ''
    );
}