<?php
namespace app\user\controller;

use app\user\model\User;
use app\user\model\UserProfile;
use lib\ReturnCode;
use think\facade\Hook;
use think\facade\Request;

/**
 * 用户管理
 * @package app\user\controller
 */
class Index extends BaseUserController
{
    protected $noNeedLogin = ['status'];
    protected $noNeedRight = [];
    protected $searchFields = ['id','username','mobile','email'];
    protected $validateAction = ['add','edit','del','save','editfield'];
    protected $statusField = '';
    protected $defaultSort = [];
    protected $with = ['profile'];

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new \app\user\model\User();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 返回用户状态
     * @param null $status
     */
    public function getStatus(){
        $status = $this->request->param('status',null);
        $data = $this->model->getStatusType($status);
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
            $user = new User();
            $profile = new UserProfile();
            $field = array_merge($user->getTableFields(),$profile->getTableFields());
            $data = $this->param($field,'post');

            if (isset($data['id']) && $data['id']){
                if ($data['id'] != $this->auth->uid){
                    $this->reError(ReturnCode::UPDATE_FAILED);
                }
                $info = $user->find($data['id']);

                //密码为空不更新
                if (isset($data['password']) && $data['password']==''){
                    unset($data['password']);
                }

                foreach ($data as $key => $value) {
                    $info->setAttr($key, $value, $data);
                    $info->profile->$key = $value;
                }
                $return = $info->together('profile')->save();
            }else{
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
                $this->reError(ReturnCode::ADD_FAILED,$user->getError());
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
        return false;
    }

    /**
     * 修改密码
     * @param string $uid
     * @return mixed|void
     */
    public function setpassword(){
        $data = $this->buildParam([
            'oldpassword'=>'oldpassword/s'
            ,'password'=>'password/s'
            ,'repassword'=>'repassword/s'
            ,'access_token'=>'access_token/s'
        ]);
        $uid = $this->auth->getUid($data['access_token']);
        if (!$uid){
            $this->reError(1030,'错误请求！！！');
        }
        if (!$data['oldpassword']){
            $this->reError(1030,'原始密码不能为空');
        }
        if (!$data['password']){
            $this->reError(1030,'密码不能为空！');
        }
        if ($data['password'] != $data['repassword']){
            $this->reError(1030,'两次密码不一致！');
        }

        Hook::listen('user_password',$data);

        $user = User::useGlobalScope(false)->find($uid);
        $oldPassword = $this->auth->passwordMd5($data['oldpassword']);
        $newPassword = $this->auth->passwordMd5($data['password']);
        $userStatus = $user->getData('status');
        $userPassword = $user->getData('password');

        if ($newPassword == $userPassword){
            $this->reError(1030,'新密码不能与旧密码相同！');
        }

        if ($user && $userStatus==1){
            if ($oldPassword == $userPassword){
                $user->password = $data['password'];
                if ($user->save()){
                    $this->reSuccess(1);
                }
            }else{
                $this->reError(1031,'原始密码不正确');
            }
        }else{
            $this->reError(1031,'用户信息不存在或被禁用！');
        }
        $this->reError(1002,'修改错误');
    }

    /**
     * Session 登录信息
     * @throws \think\Exception\DbException
     */
    public function session(){
        $uid=$this->auth->uid;
        if ($uid){
            $user = $this->model->field('id,username,status')->cache(300)->get($uid);
            $this->reSuccess($user);
        }
    }

    /**
     * 用户信息
     * @throws \think\Exception\DbException
     */
    public function userinfo(){
        $uid=$this->auth->uid;
        if ($uid){
            $user =$this->model->with('profile')->get($uid);
            $this->reSuccess($user);
        }
    }

    /**
     * 用户信息保存
     */
    public function userinfoSave(){
        $this->save();
    }

}
