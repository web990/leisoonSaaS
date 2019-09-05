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
class Vehicle extends Base{

    protected $rule = array(
        'type_id'   => 'require',
        'name'   => 'require',
        'chepai'   => 'require',
        'fadongjihao'   => 'require',
    );

    protected $message = array(
        'type_id.require'   => '选择车辆类别',
        'name.require'   => '车主姓名不能为空',
        'chepai.require'   => '车牌必填',
        'fadongjihao.require'   => '发动机号不能为空',
    );

    protected $scene = array(
        'add'   => 'type_id,chepai',
        'edit'   => 'type_id,chepai'
    );
}