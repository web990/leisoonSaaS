<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\model;
use think\model\concern\SoftDelete;

class BaseModel extends Base
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    //开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    protected function getCreateTimeAttr($value) {
        return date('Y-m-d H:i:s',$value);
    }
    protected function getUpdateTimeAttr($value) {
        return date('Y-m-d H:i:s',$value);
    }


}
