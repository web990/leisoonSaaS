<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\common\validate\system;

use app\common\validate\Base;

/**
 * 模型验证
 */
class Model extends Base{

	protected $rule = array(
			'name'   => 'require|unique:model|/^[a-zA-Z]\w{0,39}$/',
			'title'   => 'require|length:1,30'
	);
	protected $message = array(
			'name'   => '模型名错误！',
			'name.require'   => '模型名必须！',
			'name.unique'   => '模型名已存在！',
			'title.require'   => '模型标题必须！',
			'title.length'   => '模型标题长度错误！',
	);
	protected $scene = array(
			'add'     => 'name,title',
			'edit'     => 'title',
	);

}