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
 * 车辆检查
 */
class VehicleJiancha extends Base{

    protected $rule = array(
        'name'   => 'require',
        'type_id'   => 'require',
    );

    protected $message = array(
        'name.require'   => '名称不能为空',
        'type_id.require'   => '请选择检查项目',
    );

    protected $scene = array(
        'add'   => 'type_id',
        'edit'   => 'type_id'
    );
}