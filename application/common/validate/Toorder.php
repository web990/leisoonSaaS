<?php
/**
 * Created by Leisoon.
 * User: websky <web88@qq.com>
 * Date: 2018/11/12 13:40
 */

namespace app\common\validate;

 /**
 *  运单收集信息 
 */
class Toorder extends Base{

    protected $rule = array(
        'name'   => 'require',
        'title'   => 'require',
    );

    protected $message = array(
        'name.require'   => '名称不能为空',
        'title.require'   => '标题不能为空',
    );

    protected $scene = array(
        'add'   => '',
        'edit'   => ''
    );
}