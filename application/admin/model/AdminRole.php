<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\model;


use app\common\model\facade\Type;

/**
 * 角色模型
 */
class AdminRole extends BaseAdminModel {

    /**
     * 状态获取器
     * @param $value
     * @return mixed
     */
    protected function getStatusAttr($value){
        return Type::getStatus('normal',$value);
    }
    protected function setStatusAttr($value){
        return is_numeric($value) ? $value:Type::getStatus('normal',$value);
    }

}