<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\model;
use app\common\traits\model\OptimLock;
use think\model\concern\SoftDelete;

class BaseLeGuan extends Base
{
    use SoftDelete;
    use OptimLock;

    protected $deleteTime = 'delete_time';
    protected $type = array(
        'id'        => 'integer',
    );

    protected $autoWriteTimestamp = true;

    protected function getCreateTimeAttr($value) {
        return date('Y-m-d H:i:s',$value);
    }
    protected function getUpdateTimeAttr($value) {
        return date('Y-m-d H:i:s',$value);
    }

}
