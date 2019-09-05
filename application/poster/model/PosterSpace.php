<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\poster\model;

/**
 * 广告位
 */
class PosterSpace extends BasePosterModel {
    protected $readonly = ['id'];
    protected $auto = [];
    protected $insert = [];


    /**
     * 一对一关联广告模板
     * @return \think\model\relation\HasOne
     */
    public function Template()
    {
        return $this->hasOne('PosterTemplate','name','type')->bind([
            'template_name'=>'name'
            ,'template_title'=>'title'
        ]);
    }
}