<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\validate;

/**
* 验证模型
*/
class User extends Base{

	protected $rule = array(
		//'username' =>  'require|unique',
		'nickname' =>  'require',
		'password' =>  'require',
		'username' =>  'require',
		'mobile'  =>  'require|mobile',
		'idcard'  =>  'require|idCard',
	);

	protected $message = array(
        'username.require'  =>  '用户名不能为空',
        'username.unique'  =>  '用户名重复',
		'mobile.require'         =>  '手机号不能为空',
		'mobile.mobile'         =>  '手机号不正确',
		'idcard.require'         =>  '身份证为空',
		'idcard.idCard'         =>  '身份证号不正确',
		'password.require'         =>  '密码不能为空',
	);

	protected $scene = array(
		'add'   => array('username', 'mobile','idcard'),
		'edit'  => array('username','mobile','idcard')
	);

}