<?php
namespace app\admin\behavior;

use think\facade\Cache;

/**
 * 退出登录行为执行
 * @package app\admin\behavior
 */
class Logout
{
    //钩子传回一个UID参数
    public function run($uid)
    {
        Cache::rm('auth_rule_menu_'.$uid);//清除menu缓存
    }
}