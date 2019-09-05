<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\AdminModel;

/**
 * 模型
 * @package app\admin\controller
 */
class Model extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name','title'];
    protected $statusField = 'status';
    protected $with = '';

    public function __construct()
    {
        $this->validate = '\app\admin\validate\AdminModel';
        if (is_null($this->model)){
            $this->model = new AdminModel();
        }
        parent::__construct();
        parent::initialize();
    }


}
