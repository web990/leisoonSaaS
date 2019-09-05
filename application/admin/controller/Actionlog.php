<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\AdminActionLog;
use think\Db;

/**
 * 系统日志
 * Class Enterprise
 * @package app\admin\controller
 */
class Actionlog extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','title','content','module','controller','action','datatable'];
    protected $statusField = '';
    protected $with = '';

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminActionLog();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 批量删除
     * @param int $day
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function dellog($day = 30){
        if ($day < 7){
            $day = 7;
        }
        $deltime = strtotime('-'.$day.' day');

        $re = Db::name('admin_action_log')->where('create_time','<',$deltime)->delete();
        $this->reSuccess($re);
    }

}
