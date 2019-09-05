<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;


use app\admin\model\AdminDepartment;
use org\Tree;

/**
 * 部门管理
 * Class Department
 * @package app\admin\controller
 */
class Department extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name','code'];
    protected $statusField = 'department_grade_id';
    protected $defaultSort = ['sort'=>'asc'];
    protected $with = 'Grade';

    /**
     * 引入adminExtend traits
     */
    use \app\common\traits\admin\AdminExtend;

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminDepartment();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 显示资源列表
     * Author: websky
     * @return array
     */
    public function index()
    {
        $map=[];
        $query = $this->model->with($this->with)->where($map)->where($this->whereKey())->where($this->whereStatus());
        $list = $query->order('sort asc,id desc')->fetchSql(false)->select();
        $count =$query->count();
        $return_data = [
            'code' => 0,
            'msg' => '',
            'count' => $count,
            'data' => $list,
            'is' => true,
            'tip' => '操作成功！'
        ];
        return $return_data;
    }

    /**
     * 返回下拉树数据
     * Author: websky
     * @param int $roles_id
     * @return array
     */
    public function selectTree(){
        $pid = $this->request->param('pid',0);
        $map=[];
        $list = $this->model->where($map)->order('sort asc,id desc')->field('id,name,code,pid')->select();

        $data = Tree::toFormatTree($list->toArray(),'name','id','pid');
        $this->reSuccess($data);
    }




}
