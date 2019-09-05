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
 * 企业表验证器
 */
class AdminEnterprise extends AdminBase {

    protected $rule = array(
        'name|企业名称' =>  'require',
        'email|Email'  =>  'email',
        'mobile|手机号'  =>  'mobile',
    );

    protected $scene = array(
        'add'   => ['name']
        ,'edit'  => ['name']
        ,'del'  => ['id']
    );
}