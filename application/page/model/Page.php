<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\page\model;

/**
 * 独立页面
 */
class Page extends BasePageModel {
    protected $readonly = ['id'];
    protected $auto = [];
    protected $insert = [];
    protected $update = [];

    protected $type = [
        'id'    =>  'integer',
        'name'    =>  'string',
    ];


    /**
     * 一对一关联分类
     * @return \think\model\relation\HasOne
     */
    public function type()
    {
        return $this->hasOne('PageType','id','type_id')->bind([
            'type_name'=>'name'
            ,'type_template'=>'template'
        ]);
    }
}