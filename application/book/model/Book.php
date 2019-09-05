<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\book\model;

/**
 * 留言板
 */
class Book extends BaseBookModel {
    protected $readonly = ['id'];
    protected $auto = [];
    protected $insert = ['status'=>2];
    protected $update = ['re_update_time'];

    /**
     * 更新时间修改器
     * @param $value
     * @return false|int
     */
    protected function setUpdateTimeAttr($value){
        if ($value && is_string($value)){
            return strtotime($value);
        }elseif($value && is_numeric($value)){
            return $value;
        }else{
            return time();
        }
    }

    //回复时间
    protected function setReTimeAttr($value){
        if ($value && is_numeric($value)) {
            return $value;
        }elseif ($value && is_string($value)){
            return strtotime($value);
        }else{
            return time();
        }
    }
    protected function getReTimeAttr($value){
        if ($value && is_numeric($value)) {
            return date('Y-m-d H:i:s',$value);
        }
    }
    protected function setReUpdateTimeAttr($value){
        return time();
    }


    /**
     * 一对一关联分类
     * @return \think\model\relation\HasOne
     */
    public function type()
    {
        return $this->hasOne('BookType','id','type_id')->bind([
            'type_name'=>'name'
        ]);
    }
}