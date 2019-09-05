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
 * 通知公告
 */
class Notice extends Base{

    protected $rule = array(
        'user_ids'   => 'require',
        'title'   => 'require',
    );

    protected $message = array(
        'user_ids.require'   => '请选择通知用户',
        'title.require'   => '标题不能为空',
    );

    protected $scene = array(
        'add'   => 'title,user_ids',
        'edit'   => 'title'
    );
}