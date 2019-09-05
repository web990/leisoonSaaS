<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\cms\model;

use think\Model;

/**
 * 文档内容表，文档关联
 */
class DocumentContent extends Model {

    public function getContentAttr($value){
        return $value;
        //return htmlentities($value);
    }

    /**
     * Document表相对关联
     * @return \think\model\relation\BelongsTo
     */
    public function document()
    {
        return $this->belongsTo('Document');
    }

}