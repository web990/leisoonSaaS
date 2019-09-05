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
 * 电子回单
 */
class OrderHuidan extends Base{

    protected $rule = array(
        'name'   => 'require',
        'title'   => 'require',
        'shuliang'   => 'require',
        'maozhong'   => 'require',
    );

    protected $message = array(
        'name.require'   => '名称不能为空',
        'title.require'   => '标题不能为空',
        'shuliang.require'   => '数量不能为空',
        'maozhong.require'   => '毛重不能为空',
    );

    protected $scene = array(
        'add'   => '',
        'edit'   => ''
    );
}