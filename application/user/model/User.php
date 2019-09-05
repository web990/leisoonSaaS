<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\user\model;

use com\Encrypt;
use org\Date;
use think\facade\Request;

/**
 * 会员表，关联admin_memberb表
 */
class User extends BaseUserModel {
    protected $readonly = ['id','tenant_id','reg_time','reg_ip'];

    protected $insert = ['status','reg_ip','reg_time'];

    protected $type = [
        'reg_ip'    =>  'integer',
        'last_login_ip'    =>  'integer',
    ];

    /**
     * 注册IP修改器
     * @param $value
     * @return mixed
     */
    protected function setRegIpAttr($value) {
        return Request::ip(1);
    }
    protected function getRegIpAttr($value){
        return $value > 2147483647 ? $value:long2ip($value);
    }

    /**
     * 注册时间修改器
     * @param $value
     * @return float
     */
    protected function setRegTimeAttr($value) {
        if ($value){
            return is_numeric($value) ? $value:strtotime($value);
        }
        return Request::time();
    }
    protected function getRegTimeAttr($value, $data){
        return Date::dateFormat($data['reg_time'],'Y-m-d H:i');
    }

    /**
     * 密码修改器（非常规MD5加密）
     * @param $value
     * @return string
     */
    protected function setPasswordAttr($value) {
        return Encrypt::md5($value,config('auth.user_key'));
    }
    protected function getPasswordAttr($value) {
        return '';
    }

    /**
     * 用户状态获取器
     * @param $value
     * @return mixed
     */
    protected function getStatusAttr($value){
        return $this->getStatusType($value);
    }
    protected function setStatusAttr($value){
        return is_numeric($value) ? $value:$this->getStatusType($value);
    }

    /**
     * 最后登录时间获取器
     * @param $value
     * @param $data
     * @return string
     */
    protected function getLastLoginTimeAttr($value, $data){

        return Date::dateFormat($value,'Y-m-d H:i');
    }

    /**
     * 最后登录IP获取器
     * @param $value
     * @param $data
     * @return string
     */
    protected function getLastLoginIpAttr($value){
        return $value > 2147483647 ? $value:long2ip($value);
    }

    /**
     * 一对一关联用户简介
     * @return \think\model\relation\HasOne
     */
    public function profile()
    {
        return $this->hasOne('UserProfile')->bind([
            'nickname'=>'nickname'
            ,'realname'=>'realname'
            ,'score'=>'score'
            ,'idcard'=>'idcard'
            ,'sex'=>'sex'
            ,'qq'=>'qq'
            ,'wechat'=>'wechat'
            ,'birthday'=>'birthday'
            ,'headimgurl'=>'headimgurl'
            ,'address'=>'address'
            ,'tel'=>'tel'
            ,'tel_zx'=>'tel_zx'
            ,'tel_jwt'=>'tel_jwt'
            ,'tel_exp'=>'tel_exp'
        ]);
    }

    /**
     * 一对一关联用户头像
     * @return \think\model\relation\HasOne
     */
    public function heaeimg()
    {
        return $this->hasOne('\\app\\oss\\model\\Oss','id','headimg_id');
    }

    /**
     * 一对一关联用户职务
     * @return \think\model\relation\HasOne
     */
    public function zhiwu()
    {
        return $this->hasOne('\\app\\admin\\model\\AdminType','id','zhiwu_id')->bind([
            'zhiwu_name'=>'title'
        ]);
    }
    /**
     * 一对一关联用户任职情况
     * @return \think\model\relation\HasOne
     */
    public function renzhiqingkuang()
    {
        return $this->hasOne('\\app\\admin\\model\\AdminType','id','renzhiqingkuang_id')->bind([
            'renzhiqingkuang_name'=>'title'
        ]);
    }
    /**
     * 一对一关联用户警种
     * @return \think\model\relation\HasOne
     */
    public function jingzhong()
    {
        return $this->hasOne('\\app\\admin\\model\\AdminType','id','jingzhong_id')->bind([
            'jingzhong_name'=>'title'
        ]);
    }
    /**
     * 一对一关联用户警衔
     * @return \think\model\relation\HasOne
     */
    public function jingxian()
    {
        return $this->hasOne('\\app\\admin\\model\\AdminType','id','jingxian_id')->bind([
            'jingxian_name'=>'title'
        ]);
    }
    /**
     * 一对一关联用户职级
     * @return \think\model\relation\HasOne
     */
    public function zhiji()
    {
        return $this->hasOne('\\app\\admin\\model\\AdminType','id','zhiji_id')->bind([
            'zhiji_name'=>'title'
        ]);
    }

    /**
     * 角色多对多关联
     * Author: websky
     * @return \think\model\relation\BelongsToMany
     */
    public function role(){
        return $this->belongsToMany('\\app\\admin\\model\\AdminRole','\\app\\admin\\model\\AdminRoleAccess','role_id','uid');
    }

    /**
     * 一对一关联企业模型
     * @return \think\model\relation\HasOne
     */
    public function enterprise()
    {
        return $this->hasOne('\\app\\admin\\model\\AdminEnterprise','id','tenant_id');
    }

    /**
     * 返回状用户态数组/字符串/值
     * @param null $status
     * @return array|mixed|string|null
     */
    public function getStatusType($status=null){
        $type = config('?user_status_type') ? config('user_status_type'):[-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];

        if (is_numeric($status)){
            return isset($type[$status]) ? $type[$status]:'';
        }elseif (is_string($status)){
            $type = array_flip($type); // 交换数组中的键和值
            return isset($type[$status]) ? $type[$status]:'';
        }

        return $type;
    }
}