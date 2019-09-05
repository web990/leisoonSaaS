<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\AdminCategory;
use app\admin\model\AdminMenu;
use app\admin\model\AdminRole;
use app\admin\model\AdminRoleAccess;
use app\admin\model\AdminRoleExtend;
use com\Tree;
use think\Db;

/**
 * 角色管理
 * @package app\admin\controller
 */
class Role extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name','description'];
    protected $statusField = 'status';
    protected $with = '';

    public function __construct()
    {
        $this->validate='\app\admin\validate\AdminRole';
        if (is_null($this->model)){
            $this->model = new AdminRole();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 返回权限树数据
     * Author: websky
     * @param int $roles_id
     * @return array
     */
    public function ruleTree(){
        $role_id = $this->request->param('role_id');
        $checkedId = [];
        if ($role_id){
            $checkedId=$this->model->where('id',$role_id)->value('rules');
            $checkedId = explode(',',$checkedId);           //转换成数组
            $checkedId = array_map('intval', $checkedId);   //强制转换数组内容为整数类型
        }

        $map=[];
        $list = AdminMenu::where($map)->order('sort asc,id desc')->select();
        $return_data = [
            'code' => 0,
            'msg' => '获取成功！',
            'list' => $list,
            'checkedId' => $checkedId
        ];
        return $return_data;

    }
    /**
     * 保存权限赋值
     * Author: websky
     */
    public function ruleTreeSave(){
        $id = $this->isParam('id');
        $perms = $this->request->param('authids',[]);

        if ($group = $this->model->find($id)){
            $group->rules=implode(',',$perms);
            if ($group->save()){
                $this->reSuccess('修改权限成功！');
            }else{
                $this->reError(1031,'保存失败或数据无变化！');
            }
        }
        $this->reError(1030,'角色请求错误！');
    }

    /**
     * 分类权限设置
     * @throws \think\Exception
     * @return dtree数据
     */
    public function getCategoryTree(){
        $id = $this->isParam('id');
        $checklist = $formatCheck = [];
        $model = new AdminRoleExtend();

        if ($this->request->isPost()){
            $data = $this->request->post();

            if ($data && isset($data['id']) && isset($data['check']) && is_array($data['check'])){
                //按nodeId分组
                foreach ($data['check'] as $key=>$item) {
                    if ($item['dataType']==0){
                        $checklist[$item['nodeId']]['read']=$item['checked'];
                    }elseif ($item['dataType']==1){
                        $checklist[$item['nodeId']]['add']=$item['checked'];
                    }elseif ($item['dataType']==2){
                        $checklist[$item['nodeId']]['edit']=$item['checked'];
                    }elseif ($item['dataType']==3){
                        $checklist[$item['nodeId']]['delete']=$item['checked'];
                    }elseif ($item['dataType']==4){
                        $checklist[$item['nodeId']]['examine']=$item['checked'];
                    }
                }

                //清除数据库中组数据
                $model->where('role_id',$data['id'])->where('type',1)->delete(true);

                //格式化选择数组
                foreach ($checklist as $k =>&$v) {
                    $v['extend_id']=$k;
                    $v['role_id']=$data['id'];
                    $v['type']=1;
                    $formatCheck[] = $v;
                }

                //批量添加选择分类
                if ($count = $model->saveAll($formatCheck)){
                    $this->reSuccess($count);
                }
            }else{
                //清除数据库中组数据
                $re = $model->where('role_id',$data['id'])->where('type',1)->delete(true);
                $this->reSuccess($re);
            }
        }else{
            $map = [];
            $field = 'id,title,pid';
            $list = AdminCategory::where($map)->field($field)->select();

            //已选择默认勾选
            $checklist = $model->where('role_id',$id)->select();
            foreach ($list as &$item) {
                $type0 = $type1 = $type2 = $type3 = $type4 = 0;
                foreach ($checklist as $v) {
                    if ($v['extend_id'] == $item['id']){
                        $type0 =$v['read'] ? 1:0;
                        $type1 =$v['add'] ? 1:0;
                        $type2 =$v['edit'] ? 1:0;
                        $type3 =$v['delete'] ? 1:0;
                        $type4 =$v['examine'] ? 1:0;
                    }
                }

                $item['checkArr']=[
                    ['type'=>0,'checked'=>$type0]
                    ,['type'=>1,'checked'=>$type1]
                    ,['type'=>2,'checked'=>$type2]
                    ,['type'=>3,'checked'=>$type3]
                    ,['type'=>4,'checked'=>$type4]
                ];
            }

            $this->reSuccess($list);
        }
    }
}
