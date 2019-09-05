<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;
use app\admin\model\AdminRole;
use app\user\model\UserProfile;
use app\user\model\User as Users;
use lib\ReturnCode;
use think\Db;

/**
 * 用户管理
 * @author websky
 */
class User extends AdminBase
{
    protected $noNeedLogin = ['status'];
    protected $noNeedRight = [];
    protected $searchFields = ['id','username','mobile','email'];
    protected $validateAction = ['add','edit2','del','save','editfield'];
    protected $statusField = '';
    protected $defaultSort = [];
    protected $with = ['profile'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new Users();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 显示数据集
     * Author: websky
     */
    public function index()
    {
        try{
            list($where, $order, $page, $limit) = $this->whereBuild();

            if ($this->uid <=2){
                $query = Users::useGlobalScope(false)->where($where)->where('id','>',1)->where($this->whereTime());
            }else{
                $query = Users::where($where)->where('id','>',1)->where($this->whereTime());
            }
            $count = $query->count();
            $list = $query->with($this->with)->page($page,$limit)->order($order)->select();
        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::SELECT_ERROR,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::SELECT_ERROR,$e->getMessage());
        }

        $this->reTable($list,$count);
    }

    /**
     * 返回用户状态
     * @return array|mixed|string|null
     */
    public function status(){
        $data = $this->model->getStatusType();
        $this->reSuccess($data,0);
    }

    /**
     * 用户关联新增、编辑
     * @return array|void
     */
    public function save(){
        if (!$this->request->isPost()) {
            $this->reError(ReturnCode::ERROR);
        }

        try{
            $user = new \app\user\model\User();
            $profile = new UserProfile();
            $field = array_merge($user->getTableFields(),$profile->getTableFields());
            $data = $this->param($field,'post');
            $return = false;

            if (isset($data['id']) && $data['id']){
                $info = $user->find($data['id']);
                if ($info){
                    //密码为空不更新
                    if (isset($data['password']) && $data['password']==''){
                        unset($data['password']);
                    }

                    foreach ($data as $key => $value) {
                        $info->setAttr($key, $value, $data);
                        $info->profile->$key = $value;
                    }
                    $return = $info->together('profile')->save();
                }
            }else{
                if (\app\user\model\User::withTrashed()->where('username',$data['username'])->find()){
                    $this->reError(ReturnCode::USER_NOT_EXISTS,'用户名已存在');
                }

                //数据对象赋值
                foreach ($data as $key => $value) {
                    $user->setAttr($key, $value, $data);
                    $profile->setAttr($key, $value, $data);
                }
                $user->profile=$profile;
                $return = $user->together('profile')->save();
            }

            if ($return){
                $this->reSuccess(1);
            }else{
                $this->reError(isset($data['id']) ? ReturnCode::UPDATE_FAILED:ReturnCode::ADD_FAILED,$user->getError());
            }
        }catch (\think\exception\PDOException $e){
            $this->reError(ReturnCode::ADD_FAILED,$e->getMessage());
        }catch (\think\Exception $e){
            $this->reError(ReturnCode::ADD_FAILED,$e->getMessage());
        }
    }

    /**
     * 用户关联更新
     * @param int $id
     * @return array|void
     */
    public function edit($id=0){
        $this->save();
    }

    /**
     * 用户关联删除
     * @param int $id
     * @return array|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function del($id=0){
        if ($id){
            //超级管理员不允许删除
            if (!is_numeric($id) && strpos($id,',') !== false){
                foreach (explode(',',$id) as $item){
                    if ($this->auth->isSuperAdmin($item)){
                        $this->reError(906,'超级管理员不能删除！');
                    }
                }
            }else{
                if ($this->auth->isSuperAdmin($id)){
                    $this->reError(906,'超级管理员不能删除！');
                }
            }

            $pk = $this->model->getPk();

            $list = $this->model->with('profile')->where($pk,'in',$id)->select();
            $count = 0;
            foreach ($list as $v){
                $count += $v->together('profile')->delete();
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(ReturnCode::DELETE_FAILED);
            }
        }
    }

    /**
     * 返回角色树数据
     * Author: websky
     * @param int $roles_id
     * @return array
     */
    public function rolesTree(){
        $id = $this->isParam('user_id');
        $checkedId = [];
        if ($id){
            $checkedId=Db::name(config('auth.auth_group_access'))->where('uid',$id)->column('role_id');
        }

        $map=[];
        $list = AdminRole::where($map)->order('id desc')->select();
        $return_data = [
            'code' => 0,
            'msg' => '获取成功！',
            'list' => $list,
            'checkedId' => $checkedId
        ];
        return $return_data;

    }
    /**
     * 保存角色赋值
     * Author: websky
     */
    public function rolesTreeSave(){
        $id = $this->isParam('id');
        $perms = $this->request->param('authids',[]);

        $user = Users::useGlobalScope(false)->get($id);
        if ($user){
            if ($user->role()->sync($perms)){
                $this->reSuccess('修角色成功！');
            }
        }else{
            $this->reError(1030,'用户不存在！');
        }
        $this->reError(1030,'角色请求错误！');
    }


}
