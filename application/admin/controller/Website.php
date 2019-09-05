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
 * 网站配置
 * @package app\admin\controller
 */
class Website extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name','title'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminConfig();
        }
        parent::__construct();
        parent::initialize();
    }

    public function index(){
        if ($this->request->isPost()){
            $data = $this->request->post();
            unset($data['access_token']);
            //p($data,1);
            $count=1;
            foreach ($data as $key => $value) {
                $this->model->where('name',$key)->setField('value',$value);
                $count++;
            }

            //清除db_config_data缓存
            cache('admin_config_data', null);
            $this->reSuccess($count);
        }else{
            $group = $this->request->param('group','web');
            $list = $this->model->where('status',1)->order('sort asc')->select();
            $group = config('admin.config_group_list');

            //p(config('admin.'),1);

            $newarr=[];
            foreach ($group as $g=>$v){
                foreach ($list as $k=>$item){
                    if ($item['extra'] && is_string($item['extra'])){
                        $item['extra']=$this->model->parseFieldAttr($item['type'],$item['extra']);
                    }

                    if ($item['group']==$g){
                        $newarr[$g][]=$item;
                    }
                }
            }

            $data=[
                'group'=>$group
                ,'data'=>$newarr
            ];
            $this->reSuccess($data);
        }
    }

    public function index_lod(){
        if ($this->request->isPost()){
            $data = $this->buildParam([
                'title'=>'title/s'
                ,'url'=>'url/s'
                ,'close'=>'close'
                ,'icp'=>'icp/s'
                ,'keyword'=>'keyword/s'
                ,'description'=>'description/s'
                ,'copyright'=>'copyright/s'
                ,'count_code'=>'count_code/s'
            ]);
            $count=1;
            foreach ($data as $key => $value) {
                $this->model->where('name',$key)->setField('value',$value);
                $count++;
            }

            $this->reSuccess($count);

        }else{
            $group = $this->request->param('group','web');
            $map = [];
            $list = $this->model->where($map)->where('group',$group)->order('sort asc')->column('value','name');
            $this->reSuccess($list);
        }
    }

    /**
     * 解析配置信息字段
     */
    public function getFieldParse(){
        $name = $this->isParam('name');
        $re = $this->model->getFieldParse($name);
        $this->reSuccess($re);
    }


}
