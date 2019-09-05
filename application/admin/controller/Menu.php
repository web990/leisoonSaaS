<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\AdminMenu;
use com\doc\ClassMethod;
use com\Tree;

/**
 * 菜单管理
 * @package app\admin\controller
 */
class Menu extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['name','title'];
    protected $with = '';

    /**
     * 引入adminExtend traits
     */
    use \app\common\traits\admin\AdminExtend;

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminMenu();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 显示资源列表
     * Author: websky
     * @return array
     */
    public function index()
    {
        $map=[];
        $query = $this->model->with($this->with)->where($map)->where($this->whereKey())->where($this->whereStatus());
        $list = $query->order('sort asc,id desc')->fetchSql(false)->select();
        $count =$query->count();
        $return_data = [
            'code' => 0,
            'msg' => '',
            'count' => $count,
            'data' => $list,
            'is' => true,
            'tip' => '操作成功！'
        ];
        return $return_data;
    }

    /**
     * 删除分类
     * Author: websky
     * @param string $id
     */
    public function del($id='')
    {
        if ($id){
            $list = $this->model->where('id','in',$id)->select();
            $count = 0;
            foreach ($list as $v){
                //删除子类
                if ($re = $this->model->where('pid',$v->id)->update(['delete_time'=>time()])){
                    $count += $re;
                }
                $count += $v->delete();
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(ReturnCode::DELETE_FAILED);
            }
        }
    }


    /**
     * 批量快速添加
     */
    public function batch(){
        if ($this->request->isPost()){
            $data = $this->param(['name','doc','item']);
            $pid = 0;

            if(!$data['name'] || !$data['doc']){
                $this->reError(1030,'名称或描述不能为空！');
            }

            $pMenu =  $this->model->where('name',$data['name'])->find();
            if ($pMenu){
                $pid = $pMenu->id;
            }else{
                $this->model->name = $data['name'];
                $this->model->title = $data['doc'];
                $this->model->tenant_id = $this->auth->tenant_id;
                if ($this->model->isUpdate(false)->save()){
                    $pid = $this->model->id;
                }
            }

            if ($pid){
                if ($data['item'] && is_array($data['item'])){
                    $itemData=[];
                    foreach ($data['item'] as $k=>$v){
                        $itemData[$k]=[
                            'name'=>$v['name']
                            ,'title'=>$v['doc']
                            ,'tenant_id'=>$this->auth->tenant_id
                            ,'pid'=>$pid
                        ];
                    }

                    if ($re = $this->model->isUpdate(false)->saveAll($itemData)){
                        $this->reSuccess(['role'=>$pid,'item'=>$re]);
                    }
                }
            }
            $this->reError(1030,'批量添加失败！');
        }else{
            $class_name = $this->isParam('class_name');
            $isExtendClass=true;
            $group=$model='';

            if (strpos($class_name,'/') === false){
                $model='admin';
                $classPath ='app\\admin\\controller\\'.ucfirst($class_name);
            }elseif(substr($class_name,0,1)=='/'){
                //$isExtendClass=false;
                $class_name = substr($class_name,1);
                $model=strstr($class_name,'/',true);
                $controller=substr(strstr($class_name,'/'),1);
                $classPath ='app\\'.$model.'\\controller\\'.ucfirst($controller);
            }else{
                $group=strstr($class_name,'/',true);
                $controller=substr(strstr($class_name,'/'),1);
                $classPath ='app\\admin\\controller\\'.$group.'\\'.ucfirst($controller);
                //$classPath ='app\\admin\\controller\\'.str_replace('/','\\',$class_name);
            }
            if (!class_exists($classPath)){
                $this->reError(1140,'输入控制器不正确');
            }
            $class = new ClassMethod($classPath);
            $action=$class->getAction($isExtendClass);

            //分组控制器处理
            if (!empty($group) && isset($action['route'])){
                $action['route']=$group.'/'.$action['route'];
                if (isset($action['list']) && is_array($action['list'])){
                    foreach ($action['list'] as &$item) {
                        $item['route']=$group.'/'.$item['route'];
                    }
                }
            }

            //单独模型控制器处理
            if (!empty($model) && isset($action['route'])){
                $action['route']=$model.'/'.$action['route'];
                if (isset($action['list']) && is_array($action['list'])){
                    foreach ($action['list'] as &$item) {
                        $item['route']=$model.'/'.$item['route'];
                    }
                }
            }
            $this->reSuccess($action);
        }
    }


}
