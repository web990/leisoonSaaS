<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\oss\model;



/**
 * 文档表
 */
class Oss extends BaseOssModel {
    protected $updateTime = false;

    protected $readonly = ['id'];
    protected $auto = ['tenant_id'];

    public function setTenantIdAttr($value) {
        if (!$value){
            return $this->tenant_id;
        }
    }

    public function getUrlAttr($value,$data) {
        if (!$value){
            return $data['savepath'].'/'.$data['savename'];
        }
        return $value;
    }


}