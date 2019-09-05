<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\AdminEnterprise;
use app\user\model\User;
use think\Db;

/**
 * 企业管理
 * Class Enterprise
 * @package app\admin\controller
 */
class Enterprise extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','name'];
    protected $statusField = 'status';
    protected $with = '';

    public function __construct()
    {
        $this->validate='\app\common\validate\admin\AdminEnterprise';
        if (is_null($this->model)){
            $this->model = new AdminEnterprise();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 返回添加用户列表
     */
    public function userAddList(){
        $user = Db::name('user');
        $page = $this->request->param('page',1);
        $limit = $this->request->param('limit',10);

        $query = $user->where($this->whereKey('id,username,mobile,email'))->whereNull('delete_time');
        $list = $query->page($page,$limit)->order('id desc')->field('id,username,mobile,email,reg_time')->select();

        $count = $query->count();
        $this->reTable($list,$count);
    }

    /**
     * 返回企业用户列表
     */
    public function userList(){
        $id = $this->isParam('id');

        $page = $this->request->param('page',1);
        $limit = $this->request->param('limit',10);

        $query = User::useGlobalScope(false)->where('tenant_id',$id);
        $list = $query->page($page,$limit)->order('id desc')->field('id,username,mobile,email,reg_time,status')->select();

        $count = $query->count();
        $this->reTable($list,$count);
    }

    /**
     * 更新用户tenant_id
     * Author: websky
     */
    public function userUpdate(){
        $id = $this->request->param('id',0);
        $user_ids = $this->request->param('user_ids',[]);
        $count = User::useGlobalScope(false)->where('id','in',$user_ids)->where('tenant_id','<>',$id)->update(['tenant_id'=>$id]);
        $this->reSuccess($count);
    }

    /**
     * 删除用户tenant_id
     */
    public function UserDel(){
        $id = $this->request->param('id',0);
        $user_ids = $this->request->param('user_ids',[]);

        $count = User::useGlobalScope(false)->where('id','in',$user_ids)->where('tenant_id','=',$id)->update(['tenant_id'=>0]);
        $this->reSuccess($count);
    }

}
