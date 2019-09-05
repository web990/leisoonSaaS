<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\AdminConfig;

/**
 * 系统配置
 * @package app\admin\controller
 */
class Config extends AdminBase
{
    protected $noNeedLogin = ['getGroup'];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name','title'];
    protected $statusField = 'group';
    protected $defaultSort = 'group,sort';

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminConfig();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 解析配置信息字段
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getFieldParse($name=''){
        $name = $name ? $name : $this->isParam('name');
        $re = $this->model->getFieldParse($name);
        $this->reSuccess($re);
    }

    /**
     * 返回配置分组
     */
    public function getGroup(){
        $this->reSuccess($this->getFieldParse('config_group_list'));
    }

    /**
     * 排序
     */
    public function sort(){
        if ($this->request->isPost()){
            $ids = $this->request->param('ids');
            $ids = explode(',', $ids);

            $count=0;
            foreach ($ids as $key=>$value){
                $postData['id']=$value;
                $postData['sort']=$key+1;
                if ($this->model->update($postData)){
                    $count++;
                }
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(1030,'排序失败！');
            }
        }else{
            $pid = $this->request->param('group',null);
            $map=[];
            if (isset($pid) && $pid != ''){
                $map[]=['group','=',$pid];
            }
            $list = $this->model->where($map)->order('sort asc')->field('id,name,title,group,sort')->select();
            $this->reSuccess($list);
        }
    }


}
