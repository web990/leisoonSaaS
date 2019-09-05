<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\validate\admin;

/**
 * 部门登记
 */
class AdminDepartmentGrade extends AdminBase {

    protected $rule = array(
        'name'   => 'require',
    );

    protected $message = array(
        'name.require'   => '名称不能为空',
    );

    protected $scene = array(
        'add'   => 'name',
        'edit'   => 'name'
    );
}