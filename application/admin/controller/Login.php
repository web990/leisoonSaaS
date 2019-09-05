<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\library\Auth;
use lib\ReturnCode;
use app\common\controller\Base;

class Login extends Base
{

    /**
     * 登录页面
     */
    public function index()
    {
        if($this->request->isPost()){
            $param = [
                'username'=>"username/s",
                'password'=>"password/s",
                'verify'=>"verify/s",
            ];
            $data = $this->buildParam($param);

    		if(!captcha_check($data['verify'])){
                $this->reError(ReturnCode::VALIDATE_ERROR);
    		}

    		$auth = new Auth();
    		$user = $auth->login($data['username'], $data['password']);
    		if($user && is_array($user)){
    		    $this->reSuccess($user);
            } else {
                $this->reError(1021,$auth->getError());
    		}
    	}
    }

    public function login()
    {
        return $this->index();
    }

    /**
     * 退出登录
     * @return bool
     */
    public function logout(){
        $token = $this->request->param('token');
        $access_token = $this->request->param('access_token');
        $token = $token ? $token:$access_token;

        $auth = new Auth();
        if ($auth->logout($token)){
            $this->reError(1001,'退出成功！');
        }
        $this->reError(1001,'退出失败！');
    }

    /**
     * 验证码
     * @return mixed
     */
    public function verify()
    {
        $config = ['length'=>4];
        $captcha = new \think\captcha\Captcha($config);
        return $captcha->entry();
    }

}
