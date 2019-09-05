<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;


use app\admin\model\AdminChannel;

/**
 * 频道导航
 * Class Department
 * @package app\admin\controller
 */
class Channel extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['id','title','url'];
    protected $statusField = 'status';
    protected $defaultSort = ['sort'=>'asc'];

    /**
     * 引入adminExtend traits
     */
    use \app\common\traits\admin\AdminExtend;

    public function __construct()
    {
        if (is_null($this->model)){
            $this->model = new AdminChannel();
        }
        parent::__construct();
        parent::initialize();
    }

    /**
     * 显示资源列表
     * Author: websky
     * @return array
     */
    public function index()
    {
        $map=[];
        $query = $this->model->with($this->with)->where($map)->where($this->whereKey())->where($this->whereStatus());
        $list = $query->order('sort asc,id desc')->fetchSql(false)->select();
        $count =$query->count();
        $return_data = [
            'code' => 0,
            'msg' => '',
            'count' => $count,
            'data' => $list,
            'is' => true,
            'tip' => '操作成功！'
        ];
        return $return_data;
    }

}
