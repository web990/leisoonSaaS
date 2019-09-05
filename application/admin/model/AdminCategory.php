<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\model;

use org\Tree;

/**
 * Category模型
 */
class AdminCategory extends BaseAdminModel {

    protected $auto = [];
    protected $insert = ['status'=>1];
    protected $int = ['status'=>1];

    protected $type = [
        'id'    =>  'integer',
        'pid'    =>  'integer',
        'check'    =>  'integer',
        'is_wap'    =>  'integer',
        'is_paiming'    =>  'integer',
        'is_qianshou'    =>  'integer',
        'list_type'    =>  'integer',
    ];


    /**
     * 模型一对一关联
     */
    public function model(){
        return $this->hasOne('AdminModel','id','model_id');
    }

    /**
     * 图片模型一对一关联
     */
    public function picture(){
        return $this->hasOne('app\common\model\Picture','id','cover_id');
    }

    /**
     * 返回导航数组树
     * @param string $where
     * @param integer $pid
     * @param bool $field
     * @param string $order
     * @return array|false|\PDOStatement|string|\think\Collection
     */
    public function getNavTree($where='',$pid=0,$field=true,$order='sort asc,id asc')
    {
        if (!is_numeric($pid)){
            $pid=get_category_id($pid);//转换成int分类cid
        }
        $where2='';
        $map['status']=1;
        $map['is_menu']=1;
        if (is_array($where)){
            $map=array_merge($map,$where);
        }elseif (is_string($where) && $where != 'false'){
            $where2=$where;
        }
        $list=db('admin_category')->where($map)->where($where2)->field($field)->order($order)->cache(true)->select();
        $list=Tree::list_to_tree($list, 'id', 'pid', '_', $pid);
        return $list;
    }

    /**
     * 返回select树形列表
     * @param string $where
     * @param string $title
     * @param string $pk
     * @param string $pid
     * @param int $root
     */
    public static function getTree($where='',$title = 'title',$pk='id',$pid = 'pid',$root = 0){
        $category = db('admin_category')->where($where)->select();
        $category = Tree::toFormatTree($category,$title,$pk,$pid,$root);
        return $category;
    }

    /**
     * 返回子分类，如果没有子分类返回同级分类（$tongji=true）
     * @param int $id
     * @param string $type
     * @param string $tongji 是否显示同级分类，默认为true
     * @param string $where
     * @param bool $field
     * @param string $order
     * @return array|false|\PDOStatement|string|\think\Collection
     */
    public function getSubNav($id=0,$tongji=true,$where='',$field=true,$order='sort asc,id asc')
    {
        $id=get_category_id($id);//转换成int分类cid
        $where2='';
        $map['status']=1;
        $map['is_menu']=1;
        if (is_array($where)){
            $map=array_merge($map,$where);
        }elseif (is_string($where) && $where != 'false'){
            $where2=$where;
        }
        $list=db('admin_category')->where($map)->where($where2)->field($field)->order($order)->cache(true)->select();
        $list=Tree::list_to_tree($list, 'id', 'pid', '_', $id);
        if (!$list && $tongji){
            return $this->getSubNav(get_category_pid($id));
        }
        return $list;
    }

    /**
     * 返回面包屑导航，配合标签使用
     * @param int $id
     * @param array $data
     * @return array
     */
    public function getBreadcrumb($id=0,$data=array())
    {
        $id=get_category_id($id);//转换成int分类cid
        $info=db('admin_category')->where('id',$id)->field('id,pid,title,name,model_id')->cache(false)->find();
        $data[count($data)+1]=$info;
        if ($info['pid']) {
            return $this->getBreadcrumb($info['pid'],$data);
        }
        sort($data);
        return $data;
    }

    /**
     * 获取指定分类子分类ID
     * @param  string $cate 分类ID
     * @return string       id列表
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function getChildrenId($cate){
        $ids[]    = $cate;
        $cids=$this->getNavTree(false,$cate,'id,pid');
        if ($cids){
            foreach ($cids as $k=>$v){
                $ids[]=$v['id'];
            }
        }
        return implode(',', $ids);
    }

    /**
     * 返回签收IDS数组
     * @param bool $isStr
     * @return array|string
     */
    public function getQianshouIds($isName=false){
        $query = $this->where('is_qianshou',1)->where('status',1)->cache(600);

        if ($isName){
            $data = $query->column('title','id');
        }else{
            $data = $query->column('id');
        }

        return $data;
    }
}