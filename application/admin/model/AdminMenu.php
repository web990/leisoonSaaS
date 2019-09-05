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
* 设置模型
*/
class AdminMenu extends BaseAdminModel {

    protected $insert=['status'=>1];
    protected $update=[];

    //是否显示菜单
    public function setIsMenuAttr($value) {
        if ($value == 'on'){
            return 1;
        }else{
            return 0;
        }
    }

}