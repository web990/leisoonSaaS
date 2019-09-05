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
 * 部门
 * @package app\common\model
 */
class AdminDepartment extends BaseAdminModel {

    /**
     * 部门等级，一对一关联
     * Author: websky
     * @return $this
     */
    public function Grade()
    {
        return $this->hasOne('AdminDepartmentGrade','id','department_grade_id')->bind([
            'department_grade_text'=>'name'
        ]);
    }


    /**
     * 返回子ID
     * @param int $code
     * @param bool $withself
     * @param bool $isChildren 是否返回子孙数组
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getChildIds($code=0, $withself = true ,$isChildren=false){
        if ($isChildren){
            $children = $this->getChildren($code,$withself);
        }else{
            $children = $this->getChild($code,$withself);
        }

        $ids=[];
        if ($children){
            foreach ($children as $v){
                $ids[]=$v['id'];
            }
        }
        return $ids;
    }

    /**
     * 返回子孙数组
     * @param int $code 节点id
     * @param bool $withself 是否包含自身id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getChildren($code=0, $withself = true){
        return $this->getChild($code,$withself,true);
    }

    /**
     * 返回子数组
     * @param int $code 节点id
     * @param bool $withself 是否包含自身id
     * @param bool $isChildren 是否返回子孙数组
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getChild($code=0, $withself = true ,$isChildren = false){
        $tree = new Tree();
        $tree->init($this->getDeptArray());

        if ($isChildren){
            return $tree->getChildren($code,$withself);
        }else{
            return $tree->getChild($code,$withself);
        }
    }

    /**
     * 返回部门数组（缓存）
     * @param string $where
     * @param string $field
     * @param int $cache
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDeptArray($where='',$field='code as id,pid,name,sort',$cache=600){
        $data = $this->where($where)->field($field)->order('sort,id desc')->cache($cache)->select();
        return $data;
    }

}