<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\model;


/**
* 频道导航模型
*/
class AdminChannel extends BaseAdminModel {

    protected $insert=['status'=>1];
    protected $update=[];

    public function setStatusAttr($value) {
        if ($value == 'on'){
            return 1;
        }else{
            return 0;
        }
    }
    public function setTargetAttr($value) {
        if ($value == 'on'){
            return 1;
        }else{
            return 0;
        }
    }

}