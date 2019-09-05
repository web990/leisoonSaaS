<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\user\controller;

use think\captcha\Captcha;

class Verify extends BaseUserController
{
    protected $noNeedLogin=['index'];//无需登录方法
    public function __construct()
    {
        parent::__construct();
        parent::initialize();
    }

    /**
     * 验证码
     * @return mixed
     */
    public function index()
    {
        $config = ['length'=>4];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
}
