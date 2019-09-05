<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\link\model;


use app\common\model\facade\Type;

/**
 * 友情链接
 */
class Link extends BaseLinkModel {
    protected $readonly = ['id'];
    protected $auto = [];
    protected $insert = ['status'=>0];

    /*//状态修改器
    public function setStatusAttr($value){
        return is_numeric($value) ? $value:Type::getStatus('normal',$value);
    }
    public function getStatusAttr($value){
        return Type::getStatus('normal',$value);
    }*/


    /**
     * 一对一关联分类
     * @return \think\model\relation\HasOne
     */
    public function type()
    {
        return $this->hasOne('LinkType','id','type_id')->bind([
            'type_name'=>'name'
        ]);
    }

    /**
     * 一对一关联缩略图
     * @return \think\model\relation\HasOne
     */
    public function oss()
    {
        return $this->hasOne('\\app\\oss\\model\\Oss','id','cover_id')->bind([
            'cover_path'=>'url'
        ]);
    }

    /**
     * 标签调用友情链接list
     * @param int $type_id
     * @param string $field
     * @return array|\PDOStatement|string|\think\Collection
     */
    public function getLink($type_id=0,$limit=5){
        $data = $this->where('type_id',$type_id)->where('status',1)->field(true)->order('sort,id desc')->limit($limit)->cache(600)->select();
        return $data;
    }
}