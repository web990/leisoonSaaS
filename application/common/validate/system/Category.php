<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\validate\system;

use app\common\validate\Base;

/**
 * 设置模型
 */
class Category extends Base {

    protected $rule = array(
        'title'   => 'require',
        'name'   => 'require|unique:category',
    );

    protected $message = array(
        'title.require'   => '分类名称不能为空！',
        'name.require'   => '分类标识不能为空',
        'name.unique'   => '分类标识重复，请更换！',
    );

    protected $scene = array(
        'add'   => 'title,name',
        'edit'   => 'title,name'
    );
}