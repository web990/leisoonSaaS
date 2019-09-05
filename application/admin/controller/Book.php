<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

class Book extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name','title'];

    public function __construct()
    {
        //$this->validate='\app\common\validate\auth\Admin';
        if (is_null($this->model)){
            $this->model = new \app\common\model\Book();
        }
        parent::__construct();
        parent::initialize();
    }

    public function index(){

    }
}
