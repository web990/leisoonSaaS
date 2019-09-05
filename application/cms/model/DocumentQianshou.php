<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\cms\model;

use app\admin\controller\Model;
use think\model\Pivot;

/**
 * 公文签收关联表
 */
class DocumentQianshou extends Pivot {
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    protected $auto = [];
    protected $insert = [];


    public function getReadTimeAttr($value){
        if ($value){
            return date('Y-m-d H:i:s',$value);
        }else{
            return '未签收';
        }
    }

}