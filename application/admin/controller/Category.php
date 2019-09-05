<?php
// +----------------------------------------------------------------
// | LeisoonCMF V5.0
// +----------------------------------------------------------------
// | Copyright (c) 2016 http://www.leisoon.com All rights reserved.
// +----------------------------------------------------------------
// | Author: websky <web88@qq.com>
// +----------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\AdminCategory;
use com\Tree;

/**
 * 分类管理
 * @package app\admin\controller
 */
class Category extends AdminBase
{
    protected $noNeedLogin = [];
    protected $noNeedRight = [];
    protected $searchFields = ['name','title'];
    protected $with = 'model';

    /**
     * 引入adminExtend traits
     */
    use \app\common\traits\admin\AdminExtend;

    public function __construct()
    {
        $this->validate = '\app\admin\validate\AdminCategory';
        if (is_null($this->model)){
            $this->model = new AdminCategory();
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

    /**
     * 删除分类
     * Author: websky
     * @param string $id
     */
    public function del($id='')
    {
        if ($id){
            $list = $this->model->where('id','in',$id)->select();
            $count = 0;
            foreach ($list as $v){
                //删除子类
                if ($re = $this->model->where('pid',$v->id)->update(['delete_time'=>time()])){
                    $count += $re;
                }
                $count += $v->delete();
            }

            if ($count){
                $this->reSuccess($count);
            }else{
                $this->reError(ReturnCode::DELETE_FAILED);
            }
        }
    }

}
