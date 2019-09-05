<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\AdminDepartmentGrade;

/**
 * 部门等级
 * Class DepartmentGrade
 * @package app\admin\controller
 */
class DepartmentGrade extends AdminBase
{
    /**
     * 引入adminExtend traits
     */
    use \app\common\traits\admin\AdminExtend;

    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name'];
    protected $stateSelect = false;
    protected $defaultSort = ['sort'=>'asc'];
    protected $with = '';

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminDepartmentGrade();
        }
        parent::__construct();
        parent::initialize();
    }

}
