<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\user\controller;


class Login extends BaseUserController
{
    protected $noNeedLogin=['index','login','logout','verify'];//无需登录方法
    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new \app\user\model\User();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 登录页面
     */
    public function index()
    {

    }

}
