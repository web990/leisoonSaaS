<?php
namespace app\common\behavior;

use think\facade\Request;

class ActionLog
{
    /**
     * 日志记录
     * @param $object 当前响应对象
     */
    public function run($object)
    {
        \app\admin\model\AdminActionLog::record($object);
        /*if (Request::isPost()){
        }*/
    }
}