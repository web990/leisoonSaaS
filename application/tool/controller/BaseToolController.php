<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\tool\controller;

use app\common\controller\Base;
use lib\ReturnCode;
use think\facade\Hook;
use app\admin\library\Auth;

/**
 * Zhiban基础控制器类，继承Base
 * @author websky
 */
class BaseToolController extends Base
{
    protected $tenant_id=9;

    /**
     * 引入后台控制器的traits
     */
    //use \app\common\traits\admin\AdminCurd;

    public function initialize() {
        parent::initialize();

        $modulename = $this->request->module();
        $controllername = strtolower($this->request->controller());
        $actionname = strtolower($this->request->action());
        $path = $modulename.'/'.str_replace('.', '/', $controllername) . '/' . $actionname;

        $this->auth = Auth::instance($this->request->accessToken);
        $this->uid=$this->auth->uid;
        if (!$this->tenant_id){
            $this->tenant_id=$this->auth->tenant_id;
        }

        // 检测是否需要验证登录
        if (!$this->auth->match($this->noNeedLogin)) {
            //检测是否登录
            if (!$this->auth->isLogin()) {
                Hook::listen('admin_nologin', $this);
                $this->reError(ReturnCode::LOGIN_OUT);
            }
            // 判断是否需要验证权限
            if (!$this->auth->match($this->noNeedRight)) {
                // 判断控制器和方法判断是否有对应权限
                if (!$this->auth->check($path)) {
                    Hook::listen('admin_nopermission', $this);
                    $this->reError(ReturnCode::NOT_AUTH);
                }
            }
        }

        //model模型参数赋值
        if ($this->model){
            $this->model->setConfig(['tenant_id'=>$this->tenant_id,'uid'=>$this->uid]);
        }

        //模型自动验证
        if ($this->auth->match($this->validateAction)){
            //$this->validateAuto();
        }

        //读取数据库中的配置
        Hook::exec('app\\common\\behavior\\SetConfig','');
    }


}
