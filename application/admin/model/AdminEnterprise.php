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
* 企业、租户模型
*/
class AdminEnterprise extends BaseAdminModel {

    protected $insert = ['status'=>1];
    protected $update = [];

    public function getStatusTextAttr($value){
        return $name=\app\common\model\facade\Type::getValueTitle(99,$value);
    }

    /**
     * 一对一关联状态类型
     * 绑定 status_text 字段显示状态信息
     * @return \think\model\relation\HasOne
     */
    public function Type()
    {
        return $this->hasOne('app\common\model\admin\AdminType','value','status')->where(['pid'=>99])->bind([
            'status_text'=>'title'
        ]);
    }

    public function user()
    {
        return $this->belongsToMany('\\app\\user\\model\\User','AdminEnterpriseUser','user_id','enterprise_id');
    }

}