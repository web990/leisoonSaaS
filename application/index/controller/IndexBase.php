<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\index\controller;

use app\admin\model\AdminCategory;
use app\admin\model\AdminChannel;
use app\common\controller\Base;
use app\link\model\Link;
use org\Tree;
use think\facade\Hook;

/**
 * IndexBase基类，继承Base
 * @author websky
 */
class IndexBase extends Base
{
    protected $tenant_id=9;

    public function initialize() {
        parent::initialize();

        //读取数据库中的配置
        Hook::exec('app\\common\\behavior\\SetConfig',['group'=>'web','tenant_id'=>$this->tenant_id]);

        //是否关闭站点
        $this->closweb();

        //model模型参数赋值
        if ($this->model){
            $this->model->setConfig(['tenant_id'=>$this->tenant_id,'uid'=>$this->uid]);
        }
    }

    /**
     * 是否关闭站点
     */
    protected function closweb(){
        if (!config('?web.close.0') || config('web.close.0')){
            header("Content-Type: text/html; charset=utf-8");
            die('站点已关闭，请稍后访问！');
        }
    }
}
