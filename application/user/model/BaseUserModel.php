<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\user\model;

use app\common\model\Base;
use think\model\concern\SoftDelete;

class BaseUserModel extends Base
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    protected $autoWriteTimestamp = true; //开启自动写入时间戳字段

    protected $globalScope = ['TenantId']; // 定义全局的查询范围

}
