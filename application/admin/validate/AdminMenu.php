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
* 菜单规则
*/
class AdminMenu extends Base{

	protected $rule = array(
		'name' =>  'require',
		'title'  =>  'require',
	);

	protected $message = array(
		'name'  =>  '标识不能为空',
		'title'         =>  '标题描述不能为空',
	);

	protected $scene = array(
		'add'   => array('title', 'name'),
		'edit'  => array('title','name')
	);

}