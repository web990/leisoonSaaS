<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\page\controller;

use app\common\controller\Base;
use lib\ReturnCode;
use think\facade\Hook;
use app\admin\library\Auth;

/**
 * 单页面基础控制器类，继承Base
 * @author websky
 */
class BasePageController extends Base
{
    /**
     * 引入后台控制器的traits
     */
    use \app\common\traits\admin\AdminCurd;

    public function initialize()
    {
        parent::initialize();

        //权限实例化
        $this->auth = new Auth($this->request->accessToken);
        $this->uid = $this->auth->uid;
        if (!$this->tenant_id) {
            $this->tenant_id = $this->auth->tenant_id;
        }

        // 检测是否需要验证登录
        if (!$this->auth->match($this->noNeedLogin)) {
            if (!$this->auth->isLogin()) {
                Hook::listen('admin_nologin', $this);
                $this->reError(ReturnCode::LOGIN_OUT);
            }
            // 判断是否需要验证权限
            if (!$this->auth->match($this->noNeedRight)) {
                if (!$this->auth->check($this->request->pathAuth)) {
                    Hook::listen('admin_nopermission', $this);
                    $this->reError(ReturnCode::NOT_AUTH);
                }
            }
        }

        //model模型实例化后赋值tenant_id
        if ($this->model) {
            $this->model->setConfig(['tenant_id' => $this->tenant_id, 'uid' => $this->uid]);
        }

        //模型自动验证（需模型实例化后进行）
        if ($this->model && $this->auth->match($this->validateAction)) {
            $this->validateAuto();
        }
    }
}
