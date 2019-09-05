<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\cms\controller;

use app\admin\model\AdminCategory;

/**
 * 分类管理
 * @package app\admin\controller
 */
class Category extends BaseCmsController
{
    protected $noNeedLogin = ['getCategoryList'];
    protected $noNeedRight = [];
    protected $searchFields = ['name','title'];
    protected $with = '';

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminCategory();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 显示资源列表
     * Author: websky
     * @return array
     */
    public function getCategoryList()
    {
        $uid = $this->auth->uid;
        $map=[];
        $map[]=['is_menu','=',1];
        $map[]=['status','=',1];

        //获取当前用户所有的内容权限节点
        if (!$this->auth->isSuperAdmin()){
            $cate_auth  =   $this->auth->getAuthExtend($uid,1);
            $map[]=['id','in',$cate_auth];
        }
        $list = $this->model->where($map)->field('id,pid,title,sort,model_id,icon')->order('sort asc,id desc')->fetchSql(false)->select();

        $this->reSuccess($list);
    }

}
